// src/app/core/models/proveedor.model.ts

export interface Proveedor {
  id: number;
  nombre: string;
  email: string;
  telefono: string;
  direccion?: string;
  condicionesPago?: string;
  activo: boolean;
  createdAt: Date;
  updatedAt: Date;
}

export interface Compra {
  id: number;
  proveedorId: number;
  proveedor?: {
    id: number;
    nombre: string;
  };
  fecha: Date;
  items: CompraItem[];
  total: number;
  observaciones?: string;
  createdAt: Date;
  updatedAt: Date;
}

export interface CompraItem {
  id?: number;
  productoId: number;
  producto?: {
    id: number;
    nombre: string;
    codigo: string;
  };
  cantidad: number;
  precioUnitario: number;
  subtotal: number;
}

export interface CreateProveedorDto {
  nombre: string;
  email: string;
  telefono: string;
  direccion?: string;
  condicionesPago?: string;
}

export interface CreateCompraDto {
  proveedorId: number;
  fecha: Date;
  items: Omit<CompraItem, 'id' | 'producto' | 'subtotal'>[];
  observaciones?: string;
}

export interface UpdateProveedorDto extends Partial<CreateProveedorDto> {
  id: number;
}
