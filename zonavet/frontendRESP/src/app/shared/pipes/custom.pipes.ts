// src/app/shared/pipes/edad.pipe.ts

import { Pipe, PipeTransform } from '@angular/core';
import { differenceInYears, differenceInMonths } from 'date-fns';

@Pipe({
  name: 'edad',
  standalone: true
})
export class EdadPipe implements PipeTransform {
  transform(fechaNacimiento: Date | string): string {
    if (!fechaNacimiento) {
      return 'N/A';
    }
    
    const fecha = typeof fechaNacimiento === 'string' 
      ? new Date(fechaNacimiento) 
      : fechaNacimiento;
    
    const ahora = new Date();
    const años = differenceInYears(ahora, fecha);
    
    if (años >= 1) {
      return `${años} año${años > 1 ? 's' : ''}`;
    }
    
    const meses = differenceInMonths(ahora, fecha);
    return `${meses} mes${meses > 1 ? 'es' : ''}`;
  }
}

// src/app/shared/pipes/estado-badge.pipe.ts

@Pipe({
  name: 'estadoBadge',
  standalone: true
})
export class EstadoBadgePipe implements PipeTransform {
  transform(estado: string): string {
    const badgeMap: { [key: string]: string } = {
      'PENDIENTE': 'warning',
      'COMPLETADA': 'success',
      'CANCELADA': 'danger',
      'PAGADO': 'success',
      'PARCIAL': 'info',
      'ACTIVO': 'success',
      'INACTIVO': 'danger'
    };
    
    return badgeMap[estado] || 'secondary';
  }
}

// src/app/shared/pipes/nombre-completo.pipe.ts

@Pipe({
  name: 'nombreCompleto',
  standalone: true
})
export class NombreCompletoPipe implements PipeTransform {
  transform(persona: { nombre: string; apellido: string } | null): string {
    if (!persona) {
      return 'N/A';
    }
    return `${persona.nombre} ${persona.apellido}`;
  }
}
