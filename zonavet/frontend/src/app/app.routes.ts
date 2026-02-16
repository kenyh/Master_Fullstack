// src/app/app.routes.ts

import { Routes } from '@angular/router';
import { authGuard, guestGuard } from './core/guards/auth.guard';
import { adminGuard, vendedorGuard } from './core/guards/role.guard';

export const routes: Routes = [
  {
    path: '',
    redirectTo: '/dashboard',
    pathMatch: 'full',
  },

  // Rutas de autenticación (sin layout)
  {
    path: 'auth',
    canActivate: [guestGuard],
    children: [
      {
        path: 'login',
        loadComponent: () =>
          import('./features/auth/login/login.component').then((m) => m.LoginComponent),
      },
    ],
  },

  // Rutas principales (con layout)
  {
    path: '',
    canActivate: [authGuard],
    loadComponent: () =>
      import('./layouts/main-layout/main-layout.component').then((m) => m.MainLayoutComponent),
    children: [
      {
        path: 'dashboard',
        loadComponent: () =>
          import('./features/dashboard/dashboard.component').then((m) => m.DashboardComponent),
      },

      // // Usuarios (solo Admin)
      // {
      //   path: 'usuarios',
      //   canActivate: [adminGuard],
      //   loadComponent: () => import('./features/usuarios/usuarios.component')
      //     .then(m => m.UsuariosComponent)
      // },

      // // Proveedores (solo Admin)
      // {
      //   path: 'proveedores',
      //   canActivate: [adminGuard],
      //   loadComponent: () => import('./features/proveedores/proveedores.component')
      //     .then(m => m.ProveedoresComponent)
      // },

      // // Productos (solo Admin)
      // {
      //   path: 'productos',
      //   canActivate: [adminGuard],
      //   loadComponent: () => import('./features/productos/productos.component')
      //     .then(m => m.ProductosComponent)
      // },

      // // Clientes (Admin y Vendedor)
      // {
      //   path: 'clientes',
      //   canActivate: [vendedorGuard],
      //   loadComponent: () => import('./features/clientes/clientes.component')
      //     .then(m => m.ClientesComponent)
      // },

      // // Mascotas (todos)
      // {
      //   path: 'mascotas',
      //   loadComponent: () => import('./features/mascotas/mascotas.component')
      //     .then(m => m.MascotasComponent)
      // },

      // // Ventas (Admin y Vendedor)
      // {
      //   path: 'ventas',
      //   canActivate: [vendedorGuard],
      //   loadComponent: () => import('./features/ventas/ventas.component')
      //     .then(m => m.VentasComponent)
      // },

      // // Citas (todos)
      // {
      //   path: 'citas',
      //   loadComponent: () => import('./features/citas/citas.component')
      //     .then(m => m.CitasComponent)
      // },

      // // Perfil (todos)
      // {
      //   path: 'perfil',
      //   loadComponent: () => import('./features/perfil/perfil.component')
      //     .then(m => m.PerfilComponent)
      // },

      // // Cambiar contraseña (todos)
      // {
      //   path: 'cambiar-password',
      //   loadComponent: () => import('./features/perfil/cambiar-password.component')
      //     .then(m => m.CambiarPasswordComponent)
      // }
    ],
  },

  // Ruta 404
  {
    path: '**',
    redirectTo: '/dashboard',
  },
];
