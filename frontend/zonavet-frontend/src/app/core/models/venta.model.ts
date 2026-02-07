// src/app/core/models/venta.model.ts

export interface ItemVenta {
  id?: number;
  tipo: 'PRODUCTO' | 'SERVICIO';
  itemId: number;
  nombre: string;
  cantidad: number;
  precioUnitario: number;
  subtotal: number;
  mascotaId?: number; // Solo para servicios
}

export interface Venta {
  id: number;
  clienteId: number;
  cliente?: {
    id: number;
    nombre: string;
    apellido: string;
  };
  items: ItemVenta[];
  total: number;
  totalPagado: number;
  saldoPendiente: number;
  pagos: Pago[];
  estado: 'PENDIENTE' | 'PAGADO' | 'PARCIAL';
  createdAt: Date;
  updatedAt: Date;
}

export interface Pago {
  id: number;
  ventaId: number;
  monto: number;
  metodoPago?: string;
  referencia?: string;
  createdAt: Date;
}

export interface CreateVentaDto {
  clienteId: number;
  items: Omit<ItemVenta, 'id' | 'nombre' | 'subtotal'>[];
  pagoInicial?: number;
  metodoPago?: string;
}

export interface CreatePagoDto {
  ventaId: number;
  monto: number;
  metodoPago?: string;
  referencia?: string;
}

export interface EstadisticasVentas {
  totalVentas: number;
  montoTotal: number;
  montoPagado: number;
  montoPendiente: number;
  ventasPorDia: { fecha: string; total: number }[];
  topProductos: { nombre: string; cantidad: number }[];
  topServicios: { nombre: string; cantidad: number }[];
}
