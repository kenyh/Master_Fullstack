// src/app/core/models/cliente.model.ts

export interface Cliente {
  id: number;
  nombre: string;
  apellido: string;
  email: string;
  telefono: string;
  direccion?: string;
  saldo: number;
  notificaciones: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface CreateClienteDto {
  nombre: string;
  apellido: string;
  email: string;
  telefono: string;
  direccion?: string;
  notificaciones?: boolean;
}

export interface UpdateClienteDto extends Partial<CreateClienteDto> {
  id: number;
}
