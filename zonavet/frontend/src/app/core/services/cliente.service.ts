// src/app/core/services/cliente.service.ts

import { Injectable, signal } from '@angular/core';
import { Observable, of } from 'rxjs';
import { delay, map } from 'rxjs/operators';
import { BaseService } from './base.service';
import { Cliente, CreateClienteDto, UpdateClienteDto, PaginatedResponse } from '../models';

@Injectable({
  providedIn: 'root'
})
export class ClienteService extends BaseService<Cliente, CreateClienteDto, UpdateClienteDto> {
  protected apiUrl = '/api/clientes';
  
  // Signal para gestionar clientes en memoria (mock)
  private clientesSignal = signal<Cliente[]>([
    {
      id: 1,
      nombre: 'Juan',
      apellido: 'Pérez',
      email: 'juan.perez@email.com',
      telefono: '555-1001',
      direccion: 'Calle 123 #45-67',
      saldo: 0,
      notificaciones: true,
      createdAt: new Date('2024-01-15'),
      updatedAt: new Date('2024-01-15')
    },
    {
      id: 2,
      nombre: 'María',
      apellido: 'González',
      email: 'maria.gonzalez@email.com',
      telefono: '555-1002',
      direccion: 'Avenida 456 #78-90',
      saldo: 50000,
      notificaciones: true,
      createdAt: new Date('2024-01-20'),
      updatedAt: new Date('2024-01-20')
    },
    {
      id: 3,
      nombre: 'Carlos',
      apellido: 'Rodríguez',
      email: 'carlos.rodriguez@email.com',
      telefono: '555-1003',
      direccion: 'Carrera 789 #12-34',
      saldo: 25000,
      notificaciones: false,
      createdAt: new Date('2024-02-01'),
      updatedAt: new Date('2024-02-01')
    }
  ]);
  
  readonly clientes = this.clientesSignal.asReadonly();
  
  // Obtener clientes con saldo pendiente
  getClientesConSaldo(): Observable<Cliente[]> {
    if (this.useMockData) {
      return of(this.clientesSignal().filter(c => c.saldo > 0)).pipe(delay(300));
    }
    return this.http.get<Cliente[]>(`${this.apiUrl}/con-saldo`);
  }
  
  /**
   * Implementación de métodos mock
   */
  
  protected getMockData(params?: any): Observable<PaginatedResponse<Cliente>> {
    let clientes = [...this.clientesSignal()];
    
    // Aplicar búsqueda
    if (params?.search) {
      const search = params.search.toLowerCase();
      clientes = clientes.filter(c => 
        c.nombre.toLowerCase().includes(search) ||
        c.apellido.toLowerCase().includes(search) ||
        c.email.toLowerCase().includes(search) ||
        c.telefono.includes(search)
      );
    }
    
    // Ordenamiento
    if (params?.sortBy) {
      clientes.sort((a, b) => {
        const aVal = a[params.sortBy as keyof Cliente];
        const bVal = b[params.sortBy as keyof Cliente];
        const order = params.sortOrder === 'desc' ? -1 : 1;
        //FIXME: sacar !
        return aVal! > bVal! ? order : -order;
      });
    }
    
    // Paginación
    const page = params?.page || 1;
    const limit = params?.limit || 10;
    const start = (page - 1) * limit;
    const end = start + limit;
    const paginatedData = clientes.slice(start, end);
    
    const response: PaginatedResponse<Cliente> = {
      data: paginatedData,
      total: clientes.length,
      page,
      limit,
      totalPages: Math.ceil(clientes.length / limit)
    };
    
    return of(response).pipe(delay(500));
  }
  
  protected getMockById(id: number): Observable<Cliente> {
    const cliente = this.clientesSignal().find(c => c.id === id);
    if (!cliente) {
      throw new Error('Cliente no encontrado');
    }
    return of(cliente).pipe(delay(300));
  }
  
  protected createMock(data: CreateClienteDto): Observable<Cliente> {
    const newCliente: Cliente = {
      ...data,
      id: Math.max(...this.clientesSignal().map(c => c.id), 0) + 1,
      saldo: 0,
      notificaciones: data.notificaciones ?? true,
      createdAt: new Date(),
      updatedAt: new Date()
    };
    
    this.clientesSignal.update(clientes => [...clientes, newCliente]);
    return of(newCliente).pipe(delay(500));
  }
  
  protected updateMock(id: number, data: UpdateClienteDto): Observable<Cliente> {
    const index = this.clientesSignal().findIndex(c => c.id === id);
    if (index === -1) {
      throw new Error('Cliente no encontrado');
    }
    
    const updatedCliente: Cliente = {
      ...this.clientesSignal()[index],
      ...data,
      updatedAt: new Date()
    };
    
    this.clientesSignal.update(clientes => [
      ...clientes.slice(0, index),
      updatedCliente,
      ...clientes.slice(index + 1)
    ]);
    
    return of(updatedCliente).pipe(delay(500));
  }
  
  protected deleteMock(id: number): Observable<void> {
    this.clientesSignal.update(clientes => clientes.filter(c => c.id !== id));
    return of(void 0).pipe(delay(500));
  }
}
