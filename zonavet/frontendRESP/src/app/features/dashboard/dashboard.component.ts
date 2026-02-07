// src/app/features/dashboard/dashboard.component.ts

import { Component, OnInit, inject, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';

// PrimeNG
import { CardModule } from 'primeng/card';
import { ButtonModule } from 'primeng/button';
import { ChipModule } from 'primeng/chip';
import { TableModule } from 'primeng/table';
import { TagModule } from 'primeng/tag';
import { SkeletonModule } from 'primeng/skeleton';

import { AuthService } from '../../core/services/auth.service';
import { DashboardStats } from '../../core/models';
import { FormatCurrencyPipe } from '../../shared/pipes/format-currency.pipe';

@Component({
    selector: 'app-dashboard',
    imports: [
        CommonModule,
        RouterModule,
        CardModule,
        ButtonModule,
        ChipModule,
        TableModule,
        TagModule,
        SkeletonModule,
        FormatCurrencyPipe
    ],
    templateUrl: './dashboard.component.html',
    styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  authService = inject(AuthService);
  private router = inject(Router);
  
  // Signals
  loading = signal(true);
  stats = signal<DashboardStats>({
    totalClientes: 45,
    totalMascotas: 78,
    citasPendientes: 12,
    ventasHoy: 8,
    ventasDiaActual: 1250000,
    alertasStock: 5,
    alertasVencimiento: 3,
    clientesSaldoPendiente: 7
  });
  
  // Datos mock para alertas
  productosStockBajo = signal([
    { nombre: 'Alimento Perro Adulto', stock: 3, stockMinimo: 10 },
    { nombre: 'Shampoo Antipulgas', stock: 2, stockMinimo: 5 },
    { nombre: 'Vacuna Triple Felina', stock: 5, stockMinimo: 10 }
  ]);
  
  clientesSaldoPendiente = signal([
    { id: 1, nombre: 'María González', saldo: 50000 },
    { id: 2, nombre: 'Carlos Rodríguez', saldo: 25000 },
    { id: 3, nombre: 'Ana Martínez', saldo: 75000 }
  ]);
  
  citasHoy = signal([
    { 
      id: 1, 
      hora: '09:00', 
      cliente: 'Juan Pérez', 
      mascota: 'Max', 
      motivo: 'Consulta general' 
    },
    { 
      id: 2, 
      hora: '10:30', 
      cliente: 'María González', 
      mascota: 'Luna', 
      motivo: 'Vacunación' 
    },
    { 
      id: 3, 
      hora: '14:00', 
      cliente: 'Carlos Rodríguez', 
      mascota: 'Rocky', 
      motivo: 'Control post-operatorio' 
    }
  ]);
  
  
  currentUser = computed(() => this.authService.currentUser());
  isAdmin = computed(() => this.authService.isAdmin());
  isVendedor = computed(() => this.authService.isVendedor());
  
  ngOnInit(): void {
    // Simular carga de datos
    setTimeout(() => {
      this.loading.set(false);
    }, 1000);
  }
  
  navigateTo(route: string): void {
    this.router.navigate([route]);
  }
  
  getSeverity(stock: number, stockMinimo: number): 'danger' | 'warning' | 'success' {
    if (stock === 0) return 'danger';
    if (stock < stockMinimo / 2) return 'danger';
    if (stock < stockMinimo) return 'warning';
    return 'success';
  }
}
