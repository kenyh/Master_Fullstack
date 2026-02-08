// src/app/core/models/cita.model.ts

export type EstadoCita = 'PENDIENTE' | 'COMPLETADA' | 'CANCELADA';

export interface Cita {
  id: number;
  clienteId: number;
  cliente?: {
    id: number;
    nombre: string;
    apellido: string;
  };
  mascotaId?: number;
  mascota?: {
    id: number;
    nombre: string;
    especie: string;
  };
  fecha: Date;
  hora: string;
  motivo: string;
  servicios: CitaServicio[];
  estado: EstadoCita;
  observaciones?: string;
  createdAt: Date;
  updatedAt: Date;
}

export interface CitaServicio {
  id: number;
  servicioId: number;
  servicio?: {
    id: number;
    nombre: string;
    precio: number;
  };
}

export interface CreateCitaDto {
  clienteId: number;
  mascotaId?: number;
  fecha: Date;
  hora: string;
  motivo: string;
  servicios: number[]; // IDs de servicios
}

export interface UpdateCitaDto {
  id: number;
  fecha?: Date;
  hora?: string;
  motivo?: string;
  observaciones?: string;
}

export interface EstadisticasCitas {
  totalCitas: number;
  pendientes: number;
  completadas: number;
  canceladas: number;
  citasHoy: number;
  citasPorDia: { fecha: string; total: number }[];
}
