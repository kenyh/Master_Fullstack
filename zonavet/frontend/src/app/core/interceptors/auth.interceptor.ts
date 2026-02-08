// src/app/core/interceptors/auth.interceptor.ts

import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { AuthService } from '../services/auth.service';

/**
 * Interceptor para agregar el token de autenticación a todas las peticiones HTTP
 */
export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const authService = inject(AuthService);
  const token = authService.token();
  
  // Si existe token y la petición es a nuestra API, agregar el header
  if (token && req.url.startsWith('/api')) {
    req = req.clone({
      setHeaders: {
        Authorization: `Bearer ${token}`
      }
    });
  }
  
  return next(req);
};

/**
 * Interceptor para manejo de errores HTTP
 */
export const errorInterceptor: HttpInterceptorFn = (req, next) => {
  const authService = inject(AuthService);
  
  return next(req).pipe(
    // tap({
    //   error: (error) => {
    //     if (error.status === 401) {
    //       // Token expirado o inválido
    //       authService.logout();
    //     }
    //   }
    // })
  );
};
