// src/app/layouts/main-layout/main-layout.component.ts

import { Component, OnInit, inject, signal, computed } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';

// PrimeNG
import { SidebarModule } from 'primeng/sidebar';
import { ButtonModule } from 'primeng/button';
import { MenuModule } from 'primeng/menu';
import { AvatarModule } from 'primeng/avatar';
import { BadgeModule } from 'primeng/badge';
import { RippleModule } from 'primeng/ripple';
import { TooltipModule } from 'primeng/tooltip';

import { AuthService } from '../../core/services/auth.service';
import { MenuItem } from 'primeng/api';

@Component({
  selector: 'app-main-layout',
  standalone: true,
  imports: [
    CommonModule,
    RouterModule,
    SidebarModule,
    ButtonModule,
    MenuModule,
    AvatarModule,
    BadgeModule,
    RippleModule,
    TooltipModule
  ],
  templateUrl: './main-layout.component.html',
  styleUrls: ['./main-layout.component.scss']
})
export class MainLayoutComponent implements OnInit {
  authService = inject(AuthService);
  private router = inject(Router);
  
  // Signals
  sidebarVisible = signal(false);
  menuItems = signal<MenuItem[]>([]);
  

  currentUser = computed(() => this.authService.currentUser());
  isAdmin = computed(() => this.authService.isAdmin());
  isVendedor = computed(() => this.authService.isVendedor());
  isVeterinario = computed(() => this.authService.isVeterinario());
  userInitials = computed(() => {
    const user = this.currentUser();
    if (!user) return 'U';
    return `${user.nombre.charAt(0)}${user.apellido.charAt(0)}`.toUpperCase();
  });
  
  ngOnInit(): void {
    this.buildMenu();
  }
  
  private buildMenu(): void {
    const items: MenuItem[] = [
      {
        label: 'Dashboard',
        icon: 'pi pi-home',
        command: () => this.navigate('/dashboard')
      }
    ];
    
    // Administrador: acceso completo
    if (this.isAdmin()) {
      items.push(
        {
          label: 'Usuarios',
          icon: 'pi pi-users',
          command: () => this.navigate('/usuarios')
        },
        {
          label: 'Proveedores',
          icon: 'pi pi-building',
          command: () => this.navigate('/proveedores')
        },
        {
          label: 'Productos y Servicios',
          icon: 'pi pi-box',
          command: () => this.navigate('/productos')
        }
      );
    }
    
    // Administrador y Vendedor
    if (this.isAdmin() || this.isVendedor()) {
      items.push(
        {
          label: 'Clientes',
          icon: 'pi pi-user',
          command: () => this.navigate('/clientes')
        },
        {
          label: 'Mascotas',
          icon: 'pi pi-heart',
          command: () => this.navigate('/mascotas')
        },
        {
          label: 'Ventas',
          icon: 'pi pi-shopping-cart',
          command: () => this.navigate('/ventas')
        },
        {
          label: 'Citas',
          icon: 'pi pi-calendar',
          badge: '5',
          command: () => this.navigate('/citas')
        }
      );
    }
    
    // Veterinario
    if (this.isVeterinario()) {
      items.push(
        {
          label: 'Mascotas',
          icon: 'pi pi-heart',
          command: () => this.navigate('/mascotas')
        },
        {
          label: 'Citas',
          icon: 'pi pi-calendar',
          badge: '5',
          command: () => this.navigate('/citas')
        }
      );
    }
    
    // Opciones de cuenta (todos)
    items.push(
      { separator: true },
      {
        label: 'Mi Cuenta',
        icon: 'pi pi-user',
        items: [
          {
            label: 'Mi Perfil',
            icon: 'pi pi-id-card',
            command: () => this.navigate('/perfil')
          },
          {
            label: 'Cambiar Contraseña',
            icon: 'pi pi-key',
            command: () => this.navigate('/cambiar-password')
          },
          { separator: true },
          {
            label: 'Cerrar Sesión',
            icon: 'pi pi-sign-out',
            command: () => this.logout()
          }
        ]
      }
    );
    
    this.menuItems.set(items);
  }
  
  navigate(route: string): void {
    this.router.navigate([route]);
    this.sidebarVisible.set(false);
  }
  
  logout(): void {
    this.authService.logout();
  }
  
  toggleSidebar(): void {
    this.sidebarVisible.update(v => !v);
  }
}
