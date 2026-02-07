// src/app/core/guards/role.guard.ts

import { inject } from '@angular/core';
import { Router, type CanActivateFn } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { UserRole } from '../models';

/**
 * Factory para crear guards basados en roles
 * 
 * Uso en routes:
 * {
 *   path: 'usuarios',
 *   canActivate: [authGuard, roleGuard(['ADMIN'])]
 * }
 */
export const roleGuard = (allowedRoles: UserRole[]): CanActivateFn => {
  return (route, state) => {
    const authService = inject(AuthService);
    const router = inject(Router);
    
    const currentRole = authService.userRole();
    
    if (!currentRole) {
      return router.createUrlTree(['/auth/login']);
    }
    
    if (allowedRoles.includes(currentRole)) {
      return true;
    }
    
    // Usuario autenticado pero sin permisos
    return router.createUrlTree(['/dashboard']);
  };
};

/**
 * Guards específicos por rol (helpers)
 */
export const adminGuard: CanActivateFn = roleGuard(['ADMIN']);
export const vendedorGuard: CanActivateFn = roleGuard(['ADMIN', 'VENDEDOR']);
export const veterinarioGuard: CanActivateFn = roleGuard(['ADMIN', 'VETERINARIO']);
