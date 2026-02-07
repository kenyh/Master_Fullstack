 # Backend

 Para iniciar el servidor ver README.md en la raíz del proyecto

 ## dependencias

 Se borraron todas las dependencias y archivos que se corresponden con la parte frontend de laravel (vistas, node, js, etc).

Se mantienen las siguientes dependencias.

### 🚀 Dependencias de Producción - Zonavet Backend

Estas son las librerías principales (`require`) necesarias para que la API funcione en cualquier entorno:

| Paquete | Descripción | Propósito en Zonavet |
| :--- | :--- | :--- |
| **`php: ^8.5`** | Versión mínima del lenguaje. | Garantiza el uso de las últimas mejoras de rendimiento y seguridad (como tipos de intersección o readonly classes). |
| **`laravel/framework: ^12.0`** | El núcleo de la aplicación. | Provee todas las herramientas de rutas, base de datos (Eloquent), validaciones y manejo de peticiones JSON. |
| **`laravel/sanctum: ^4.0`** | Sistema de autenticación ligero. | Permite que Angular se conecte de forma segura a la API usando tokens o cookies de sesión (SPA authentication). |
| **`laravel/tinker: ^2.10.1`** | Consola interactiva (REPL). | Permite ejecutar código PHP en tiempo real para consultar o modificar la base de datos desde la terminal sin usar la interfaz. |

---

#### ¿Por qué Sanctum para la autenticación?
En lugar de usar sistemas pesados como Passport (OAuth2), usamos **Sanctum** porque es perfecto para aplicaciones donde el Frontend (Angular) y el Backend (Laravel) son del mismo dueño. Es simple, rápido y muy seguro.

#### El rol de Tinker en Producción
Aunque es una consola, se mantiene en producción para tareas de mantenimiento de emergencia, como resetear una contraseña de administrador o verificar estados de la base de datos directamente vía SSH.

### 🛠️ Dependencias de Desarrollo - Zonavet Backend

Esta es la lista de paquetes instalados en el entorno de desarrollo (`require-dev`) y su propósito dentro del proyecto:

| Paquete | Descripción | Comando principal |
| :--- | :--- | :--- |
| **`laravel/pail`** | Permite visualizar los logs de la aplicación en tiempo real directamente en la terminal. Ideal para depurar la API sin abrir archivos `.log`. | `php artisan pail` |
| **`laravel/pint`** | Corrector de estilo (Linter). Ajusta automáticamente tu código PHP para que siga los estándares de Laravel (PSR-12). | `./vendor/bin/pint` |
| **`mockery/mockery`** | Framework para crear "objetos simulados" (mocks). Permite testear lógica sin ejecutar procesos reales (ej. no enviar un mail real en un test). Al inicio no sabemos si llegamos a usarlo | N/A (Uso en código) |
| **`nunomaduro/collision`** | Mejora visual de excepciones. Transforma errores feos en la terminal en reportes legibles, con colores y contexto del código. | N/A (Automático) |
| **`pestphp/pest`** | Framework de testing moderno. Permite escribir pruebas unitarias y de integración con una sintaxis mucho más limpia que PHPUnit. Al inicio no sabemos si llegamos a usarlo. | `php artisan test` |
| **`pest-plugin-laravel`** | Integración oficial que añade herramientas específicas de Laravel a Pest (como `getJson()`, `assertDatabaseHas()`, etc). No sabemos si lo usaremos | N/A (Uso en tests) |

---