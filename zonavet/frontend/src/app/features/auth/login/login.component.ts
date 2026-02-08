// src/app/features/auth/login/login.component.ts

import { Component, inject, signal } from '@angular/core';

import { Router, RouterModule } from '@angular/router';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';

// PrimeNG
import { CardModule } from 'primeng/card';
import { InputTextModule } from 'primeng/inputtext';
import { PasswordModule } from 'primeng/password';
import { ButtonModule } from 'primeng/button';
import { CheckboxModule } from 'primeng/checkbox';
import { MessageModule } from 'primeng/message';

import { AuthService } from '../../../core/services/auth.service';

@Component({
    selector: 'app-login',
    imports: [
    ReactiveFormsModule,
    RouterModule,
    CardModule,
    InputTextModule,
    PasswordModule,
    ButtonModule,
    CheckboxModule,
    MessageModule
],
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  private fb = inject(FormBuilder);
  private authService = inject(AuthService);
  private router = inject(Router);
  
  // Signals para manejo de estado
  loading = signal(false);
  errorMessage = signal<string | null>(null);
  
  loginForm: FormGroup = this.fb.group({
    email: ['admin@ejemplo.com', [Validators.required, Validators.email]],
    password: ['admin123', [Validators.required, Validators.minLength(3)]],
    rememberMe: [false]
  });
  
  // Usuarios de ejemplo para mostrar
  usuariosEjemplo = [
    { tipo: 'Administrador', email: 'admin@ejemplo.com', password: 'admin123' },
    { tipo: 'Vendedor', email: 'vendedor@ejemplo.com', password: 'vendedor123' },
    { tipo: 'Veterinario', email: 'veterinario@ejemplo.com', password: 'vet123' }
  ];
  
  onSubmit(): void {
    if (this.loginForm.invalid) {
      this.loginForm.markAllAsTouched();
      return;
    }
    
    this.loading.set(true);
    this.errorMessage.set(null);
    
    const credentials = this.loginForm.value;
    
    this.authService.login(credentials).subscribe({
      next: () => {
        this.router.navigate(['/dashboard']);
      },
      error: (error) => {
        this.loading.set(false);
        this.errorMessage.set(error.message || 'Error al iniciar sesión');
      }
    });
  }
  
  llenarCredenciales(tipo: string): void {
    const usuario = this.usuariosEjemplo.find(u => u.tipo === tipo);
    if (usuario) {
      this.loginForm.patchValue({
        email: usuario.email,
        password: usuario.password
      });
    }
  }
  
  get email() {
    return this.loginForm.get('email');
  }
  
  get password() {
    return this.loginForm.get('password');
  }
}
