// src/app/core/services/auth.service.ts

import { Injectable, inject, signal, computed } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, of, throwError } from 'rxjs';
import { map, tap, catchError, delay } from 'rxjs/operators';
import { User, LoginRequest, LoginResponse, UserRole } from '../models';

// Usuarios mock para desarrollo
const MOCK_USERS: User[] = [
  {
    id: 1,
    nombre: 'Admin',
    apellido: 'Sistema',
    email: 'admin@ejemplo.com',
    tipo: 'ADMIN',
    telefono: '555-0001',
    activo: true,
    createdAt: new Date(),
    updatedAt: new Date()
  },
  {
    id: 2,
    nombre: 'Carlos',
    apellido: 'Vendedor',
    email: 'vendedor@ejemplo.com',
    tipo: 'VENDEDOR',
    telefono: '555-0002',
    activo: true,
    createdAt: new Date(),
    updatedAt: new Date()
  },
  {
    id: 3,
    nombre: 'Ana',
    apellido: 'Veterinaria',
    email: 'veterinario@ejemplo.com',
    tipo: 'VETERINARIO',
    telefono: '555-0003',
    activo: true,
    createdAt: new Date(),
    updatedAt: new Date()
  }
];

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private http = inject(HttpClient);
  private router = inject(Router);
  
  // Signals para manejo de estado reactivo
  private currentUserSignal = signal<User | null>(null);
  private tokenSignal = signal<string | null>(null);
  
  // Calcula signals
  readonly currentUser = this.currentUserSignal.asReadonly();
  readonly token = this.tokenSignal.asReadonly();
  readonly isAuthenticated = computed(() => !!this.currentUserSignal());
  readonly userRole = computed(() => this.currentUserSignal()?.tipo || null);
  
  // Permisos calculados
  readonly isAdmin = computed(() => this.userRole() === 'ADMIN');
  readonly isVendedor = computed(() => this.userRole() === 'VENDEDOR');
  readonly isVeterinario = computed(() => this.userRole() === 'VETERINARIO');
  
  constructor() {
    // Cargar usuario desde localStorage si existe
    this.loadUserFromStorage();
  }
  
  /**
   * Login - Simula llamada a API
   */
  login(credentials: LoginRequest): Observable<LoginResponse> {
    // TODO: Reemplazar con llamada real a API
    // return this.http.post<LoginResponse>('/api/auth/login', credentials);
    
    // Mock login
    return of(null).pipe(
      delay(500), // Simula latencia
      map(() => {
        const user = MOCK_USERS.find(u => u.email === credentials.email);
        
        if (!user) {
          throw new Error('Usuario no encontrado');
        }
        
        // Validar password (en mock, cualquier password funciona excepto vacío)
        if (!credentials.password || credentials.password.length < 3) {
          throw new Error('Contraseña inválida');
        }
        
        const token = this.generateMockToken(user);
        const response: LoginResponse = { token, user };
        
        return response;
      }),
      tap(response => {
        this.setAuth(response.token, response.user);
      }),
      catchError(error => throwError(() => error))
    );
  }
  
  /**
   * Logout
   */
  logout(): void {
    this.clearAuth();
    this.router.navigate(['/auth/login']);
  }
  
  /**
   * Verificar si el usuario tiene un rol específico
   */
  hasRole(role: UserRole): boolean {
    return this.userRole() === role;
  }
  
  /**
   * Verificar si el usuario tiene alguno de los roles
   */
  hasAnyRole(roles: UserRole[]): boolean {
    const currentRole = this.userRole();
    return currentRole ? roles.includes(currentRole) : false;
  }
  
  /**
   * Cambiar contraseña
   */
  changePassword(oldPassword: string, newPassword: string): Observable<void> {
    // TODO: Implementar llamada a API
    return of(void 0).pipe(delay(500));
  }
  
  /**
   * Métodos privados
   */
  
  private setAuth(token: string, user: User): void {
    this.tokenSignal.set(token);
    this.currentUserSignal.set(user);
    
    // Guardar en localStorage
    localStorage.setItem('auth_token', token);
    localStorage.setItem('current_user', JSON.stringify(user));
  }
  
  private clearAuth(): void {
    this.tokenSignal.set(null);
    this.currentUserSignal.set(null);
    
    // Limpiar localStorage
    localStorage.removeItem('auth_token');
    localStorage.removeItem('current_user');
  }
  
  private loadUserFromStorage(): void {
    const token = localStorage.getItem('auth_token');
    const userStr = localStorage.getItem('current_user');
    
    if (token && userStr) {
      try {
        const user = JSON.parse(userStr) as User;
        this.tokenSignal.set(token);
        this.currentUserSignal.set(user);
      } catch (error) {
        this.clearAuth();
      }
    }
  }
  
  private generateMockToken(user: User): string {
    // Token mock -  vendría del backend
    return `mock_token_${user.id}_${Date.now()}`;
  }
}
