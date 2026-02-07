// src/app/core/models/mascota.model.ts

export type Especie = 'CANINO' | 'FELINO' | 'OTRO';
export type Sexo = 'M' | 'F';

export interface Mascota {
  id: number;
  nombre: string;
  especie: Especie;
  raza: string;
  sexo: Sexo;
  fechaNacimiento: Date;
  edad?: string; // Calculado
  color?: string;
  peso?: number;
  clienteId: number;
  cliente?: {
    id: number;
    nombre: string;
    apellido: string;
  };
  createdAt: Date;
  updatedAt: Date;
}

export interface CreateMascotaDto {
  nombre: string;
  especie: Especie;
  raza: string;
  sexo: Sexo;
  fechaNacimiento: Date;
  color?: string;
  peso?: number;
  clienteId: number;
}

export interface UpdateMascotaDto extends Partial<CreateMascotaDto> {
  id: number;
}
