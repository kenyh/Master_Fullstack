// src/app/core/models/user.model.ts

export type UserRole = 'ADMIN' | 'VENDEDOR' | 'VETERINARIO';

export interface User {
  id: number;
  nombre: string;
  apellido: string;
  email: string;
  tipo: UserRole;
  telefono?: string;
  direccion?: string;
  activo: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface LoginRequest {
  email: string;
  password: string;
}

export interface LoginResponse {
  token: string;
  user: User;
}

export interface AuthState {
  isAuthenticated: boolean;
  user: User | null;
  token: string | null;
}
