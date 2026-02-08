// src/app/core/services/base.service.ts

import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { delay } from 'rxjs/operators';
import { ApiResponse, PaginatedResponse } from '../models';

export interface QueryParams {
  page?: number;
  limit?: number;
  search?: string;
  sortBy?: string;
  sortOrder?: 'asc' | 'desc';
  [key: string]: any;
}

/**
 * Servicio base genérico para operaciones CRUD
 */
@Injectable({
  providedIn: 'root'
})
export abstract class BaseService<T, CreateDto = any, UpdateDto = any> {
  protected http = inject(HttpClient);
  protected abstract apiUrl: string;
  protected useMockData = true; // Cambiar a false cuando conecte  backend o eliminar
  
  /**
   * Obtener todos los registros (paginado)
   */
  getAll(params?: QueryParams): Observable<PaginatedResponse<T>> {
    if (this.useMockData) {
      return this.getMockData(params);
    }
    
    const httpParams = this.buildHttpParams(params);
    return this.http.get<PaginatedResponse<T>>(this.apiUrl, { params: httpParams });
  }
  
  /**
   * Obtener un registro por ID
   */
  getById(id: number): Observable<T> {
    if (this.useMockData) {
      return this.getMockById(id);
    }
    
    return this.http.get<T>(`${this.apiUrl}/${id}`);
  }
  
  /**
   * Crear un nuevo registro
   */
  create(data: CreateDto): Observable<T> {
    if (this.useMockData) {
      return this.createMock(data);
    }
    
    return this.http.post<T>(this.apiUrl, data);
  }
  
  /**
   * Actualizar un registro
   */
  update(id: number, data: UpdateDto): Observable<T> {
    if (this.useMockData) {
      return this.updateMock(id, data);
    }
    
    return this.http.put<T>(`${this.apiUrl}/${id}`, data);
  }
  
  /**
   * Eliminar un registro
   */
  delete(id: number): Observable<void> {
    if (this.useMockData) {
      return this.deleteMock(id);
    }
    
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
  
  /**
   * Métodos helper
   */
  
  protected buildHttpParams(params?: QueryParams): HttpParams {
    let httpParams = new HttpParams();
    
    if (params) {
      Object.keys(params).forEach(key => {
        const value = params[key];
        if (value !== null && value !== undefined) {
          httpParams = httpParams.set(key, value.toString());
        }
      });
    }
    
    return httpParams;
  }
  
  /**
   * Métodos mock - Deben ser implementados por servicios hijos
   */
  
  protected abstract getMockData(params?: QueryParams): Observable<PaginatedResponse<T>>;
  protected abstract getMockById(id: number): Observable<T>;
  protected abstract createMock(data: CreateDto): Observable<T>;
  protected abstract updateMock(id: number, data: UpdateDto): Observable<T>;
  protected abstract deleteMock(id: number): Observable<void>;
  
  /**
   * Helper para simular delay en operaciones mock
   */
  protected mockDelay<R>(data: R, ms: number = 500): Observable<R> {
    return of(data).pipe(delay(ms));
  }
}
