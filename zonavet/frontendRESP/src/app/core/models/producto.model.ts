// src/app/core/models/producto.model.ts

export type TipoProducto = 'PRODUCTO' | 'SERVICIO' | 'MENSUALIDAD';
export type CategoriaProducto = 'MEDICAMENTO' | 'ALIMENTO' | 'ACCESORIO' | 'HIGIENE' | 'JUGUETE' | 'OTRO';
export type CategoriaServicio = 'CONSULTA' | 'CIRUGIA' | 'VACUNACION' | 'PARACLINICOS' | 'HOSPITALIZACION' | 'OTRO';

export interface Producto {
  id: number;
  codigo: string;
  nombre: string;
  descripcion?: string;
  tipo: TipoProducto;
  categoria: CategoriaProducto;
  precio: number;
  stock: number;
  stockMinimo: number;
  fechaVencimiento?: Date;
  diasAlertaVencimiento?: number;
  activo: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface Servicio {
  id: number;
  codigo: string;
  nombre: string;
  descripcion?: string;
  categoria: CategoriaServicio;
  precio: number;
  duracionMinutos?: number;
  activo: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface CreateProductoDto {
  codigo: string;
  nombre: string;
  descripcion?: string;
  categoria: CategoriaProducto;
  precio: number;
  stock: number;
  stockMinimo: number;
  fechaVencimiento?: Date;
  diasAlertaVencimiento?: number;
}

export interface CreateServicioDto {
  codigo: string;
  nombre: string;
  descripcion?: string;
  categoria: CategoriaServicio;
  precio: number;
  duracionMinutos?: number;
}

export interface UpdateProductoDto extends Partial<CreateProductoDto> {
  id: number;
}

export interface UpdateServicioDto extends Partial<CreateServicioDto> {
  id: number;
}

export interface AlertaStock {
  producto: Producto;
  tipo: 'STOCK_BAJO' | 'POR_VENCER';
  diasRestantes?: number;
}
