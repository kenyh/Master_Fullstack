// src/app/core/models/index.ts

export * from './user.model';
export * from './cliente.model';
export * from './mascota.model';
export * from './producto.model';
export * from './venta.model';
export * from './cita.model';
export * from './proveedor.model';


// Interfaces comunes
export interface ApiResponse<T> {
  success: boolean;
  data: T;
  message?: string;
  error?: string;
}

export interface PaginatedResponse<T> {
  data: T[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
}

export interface DashboardStats {
  totalClientes: number;
  totalMascotas: number;
  citasPendientes: number;
  ventasHoy: number;
  ventasDiaActual: number;
  alertasStock: number;
  alertasVencimiento: number;
  clientesSaldoPendiente: number;
}
