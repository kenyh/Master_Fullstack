# Actividad 1 - Frontend: Juego del Solitario VIU

## 1 - INTRODUCCIÓN

La actividad consiste en implementar una versión elemental del juego del solitario utilizando HTML, CSS y JavaScript vanilla, con soporte de la librería Bootstrap para el diseño responsivo.

### 1.1 Reglas del Juego

El juego utiliza una **baraja VIU** personalizada con las siguientes características:

- **Números**: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 y 12
- **Palos**: 4 tipos (vius, cuadrados, hexágonos y círculos)
- **Colores**: 2 colores (naranja y gris)
  - Naranja: vius y cuadrados
  - Gris: hexágonos y círculos

### 1.2 Elementos del Juego

El juego cuenta con **6 tapetes** (superficies que contienen mazos de cartas):

1. **Tapete Inicial**: Contiene el mazo completo barajado aleatoriamente al inicio
2. **Tapete de Sobrantes**: Para depositar temporalmente cartas del mazo inicial
3. **Cuatro Tapetes Receptores**: Donde se van acumulando las cartas en orden decreciente

### 1.3 Mecánica del Juego

#### Tapete Inicial

- Contiene todas las cartas barajadas al inicio
- Las cartas se pueden mover de una en una haciendo **click** en la carta superior
- Al hacer click, la carta se mueve automáticamente al tapete de sobrantes

#### Tapete de Sobrantes

- Acepta cualquier carta proveniente del tapete inicial
- La última carta depositada puede ser **arrastrada** a los tapetes receptores
- Sirve como fuente alternativa de cartas

#### Tapetes Receptores (4 tapetes)

- Solo aceptan cartas en **orden decreciente** (comenzando obligatoriamente con el 12)
- Las cartas deben **alternar colores** (naranja → gris → naranja...)
- Una vez depositada una carta, no se puede mover a otro tapete

#### Reciclaje del Mazo

- Cuando el tapete inicial se vacía, las cartas del tapete de sobrantes son:
  - Barajadas automáticamente
  - Colocadas de nuevo en el tapete inicial
  - El juego continúa con estas cartas restantes

#### Finalización del Juego

El juego termina cuando **ambos** tapetes (inicial y sobrantes) están vacíos, mostrando:

- Mensaje de victoria
- Tiempo total de juego (formato HH:MM:SS)
- Número total de movimientos realizados

---

## 2 - DESARROLLO

### 2.1 Estructura del Proyecto

```
proyecto/
│
├── index.html              # Redirige a solitario.html
├── solitario.html          # Página principal del juego
│
├── css/
│   └── solitario.css       # Estilos del juego
│
├── js/
│   └── solitario.js        # Lógica del juego
│
└── imagenes/
    ├── logoVIU.png         # Logo de VIU
    └── baraja/             # Imágenes de las cartas
        ├── 1-viu.png
        ├── 2-viu.png
        ├── ...
        └── 12-cir.png
```

### 2.2 Tecnologías Utilizadas

- **HTML5**: Estructura semántica del juego
- **CSS3**: Estilos y diseño responsive
- **JavaScript ES6+**: Lógica del juego (vanilla JS)
- **Bootstrap 5.3.8**: Framework CSS para componentes y grid system
- **Bootstrap Icons**: Iconografía (reloj, movimientos, reset)

### 2.3 Características Implementadas

#### 2.3.1 Interfaz de Usuario

**Header**

- Título del juego con logo VIU
- Contador de tiempo en formato HH:MM:SS
- Contador de movimientos realizados
- Diseño responsive con Bootstrap grid

**Main**

- Mesa de juego con fondo verde (#80af8f)
- 6 tapetes claramente diferenciados:
  - Tapete inicial: Sin borde, contiene cartas apiladas
  - Tapete sobrantes: Fondo azul claro (lightblue)
  - 4 Tapetes receptores: Fondo verde claro (lightgreen)

**Footer**

- Botón de reinicio (circular, color rojo)
- Icono de reinicio de Bootstrap Icons

**Modal de Victoria**

- Se muestra al completar el juego
- Muestra estadísticas finales
- Botón para cerrar

#### 2.3.2 Funcionalidad JavaScript

**Funciones Principales**

1. `comenzarJuego()`: Inicializa una nueva partida

   - Vacía todos los mazos
   - Genera y baraja el mazo
   - Carga cartas en el tapete inicial
   - Reinicia contadores

2. `generarMazo()`: Crea las 48 cartas (12 números × 4 palos)

   - Genera elementos `<img>` dinámicamente
   - Asigna atributos data (número, palo, color)
   - Añade event listeners

3. `barajar(mazo)`: Desordena el array de cartas aleatoriamente

   - Utiliza algoritmo de ordenamiento aleatorio
   - Ejecuta 3 pasadas para mayor aleatoriedad

4. `arrancarTiempo()`: Gestiona el cronómetro

   - Actualiza cada segundo
   - Formato HH:MM:SS
   - Se detiene al terminar el juego

5. `iniciaDrag(event)`: Maneja el inicio del arrastre

   - Guarda información de la carta arrastrada
   - Guarda el mazo de origen

6. `cartaSoltada(event)`: Procesa cuando se suelta una carta

   - Valida si el movimiento es permitido
   - Actualiza los mazos involucrados
   - Incrementa contador de movimientos
   - Verifica si el juego terminó

7. `mazoAceptaCarta(mazoDiv, cartaImg)`: Valida movimientos

   - Verifica reglas del juego (orden, colores)
   - Devuelve true/false según validez

8. `verificarJuegoTerminado()`: Detecta el fin del juego
   - Comprueba si mazos inicial y sobrantes están vacíos
   - Muestra modal con estadísticas

#### 2.3.3 Interacción del Usuario

**Sistema Dual de Movimiento**

1. **Click**: Para mover del tapete inicial a sobrantes

   - Simple click en la carta superior
   - Movimiento automático
   - Ideal para móviles

2. **Drag and Drop**: Para mover a receptores
   - Arrastrar desde tapete sobrantes
   - Soltar en tapete receptor válido
   - Feedback visual durante el arrastre

**Validaciones Implementadas**

- Solo la última carta de cada mazo es interactuable
- Los receptores solo aceptan cartas válidas (número, color)
- No se puede mover una carta al mismo mazo de origen
- El tapete inicial no acepta cartas de vuelta

#### 2.3.4 Diseño Responsive

**Media Queries Implementadas**

- **Móviles** (≤576px): Elementos más grandes para facilitar interacción táctil
- **Tablets** (577px - 768px): Diseño intermedio optimizado
- **Desktop** (≥769px): Aprovecha espacio disponible

**Optimizaciones Móviles**

- Meta viewport configurado correctamente
- Cartas y tapetes escalados dinámicamente
- Contadores con tamaño de fuente responsive
- Botón de reset más grande en pantallas pequeñas

**Características Responsive**

```css
/* Ejemplo de carta responsive */
.carta {
  width: 75px; /* Base */
}

@media (max-width: 576px) {
  .carta {
    width: 90px; /* Más grande en móvil */
  }
}
```

### 2.4 Configuración Inicial

El juego inicia con un número configurable de cartas mediante la constante:

```javascript
const NUMERO_INICIAL = 10; // Número entre 1 y 12
```

Esto permite variar la dificultad:

- `NUMERO_INICIAL = 1`: Juego completo (48 cartas)
- `NUMERO_INICIAL = 10`: Juego reducido (12 cartas) - configuración actual

---

## 3 - RESULTADOS

### 3.1 Funcionalidades Logradas

✅ **Implementación completa de las reglas del juego**

- Sistema de validación de movimientos
- Orden decreciente de cartas en receptores
- Alternancia de colores correcta
- Reciclaje automático del mazo

✅ **Interfaz de usuario intuitiva**

- Diseño limpio y profesional
- Feedback visual en hover y click
- Contadores actualizados en tiempo real
- Modal de victoria con estadísticas

✅ **Diseño responsive**

- Funciona en dispositivos móviles, tablets y desktop
- Elementos escalados apropiadamente según pantalla
- Meta viewport configurado correctamente

✅ **Sistema de interacción dual**

- Click para descartar (inicial → sobrantes)
- Drag and drop para jugar (sobrantes → receptores)

✅ **Gestión del estado del juego**

- Contador de tiempo funcional
- Contador de movimientos preciso
- Detección automática de victoria

### 3.2 Capturas de Pantalla

#### Vista Desktop

El juego se muestra con todos los elementos visibles y bien espaciados en pantallas grandes.

#### Vista Móvil

Los elementos se adaptan al tamaño de pantalla, manteniendo la jugabilidad:

- Cartas más grandes (90px vs 75px)
- Tapetes con proporciones adecuadas
- Contadores legibles

### 3.3 Pruebas Realizadas

**Funcionalidad**

- ✅ Generación correcta de 48 cartas (o según NUMERO_INICIAL)
- ✅ Barajado aleatorio funcional
- ✅ Movimiento de cartas validado correctamente
- ✅ Reciclaje del mazo cuando se vacía el inicial
- ✅ Detección correcta de fin de juego
- ✅ Modal se muestra con datos correctos

**Responsive**

- ✅ Probado en iPhone SE (375px)
- ✅ Probado en iPhone 12 (390px)
- ✅ Probado en iPad (768px)
- ✅ Probado en Desktop (1920px)

**Compatibilidad de Navegadores**

- ✅ Chrome/Edge (última versión)
- ✅ Firefox (última versión)
- ✅ Safari (última versión)

### 3.4 Desafíos y Soluciones

#### Desafío 1: Drag and Drop en Móviles

**Problema**: El drag and drop HTML5 nativo no funciona bien en dispositivos táctiles.

**Solución Implementada**: Sistema dual

- Click para mover del inicial a sobrantes (funciona en todos los dispositivos)
- Drag and drop para movimientos desde sobrantes (funciona en desktop)

**Mejora Futura**: Implementar touch events (touchstart, touchmove, touchend) para drag completo en móviles.

#### Desafío 2: Tamaños Pequeños en Móvil

**Problema**: Los elementos se veían muy pequeños en pantallas móviles.

**Solución**:

- Agregado de meta viewport correcto
- Media queries que hacen elementos MÁS GRANDES en móviles
- Uso de unidades relativas donde corresponde

#### Desafío 3: Gestión del Estado de Draggable

**Problema**: Controlar qué cartas son arrastrables en cada momento.

**Solución**:

- Solo la última carta de cada mazo es draggable
- Se actualiza dinámicamente al mover cartas
- Las cartas del tapete inicial NO son draggables (solo clickeables)

---

## 4 - CONCLUSIÓN

### 4.1 Objetivos Cumplidos

El proyecto ha logrado implementar exitosamente:

1. **Un juego funcional del solitario** que sigue todas las reglas especificadas
2. **Una interfaz responsive** que funciona en diversos dispositivos
3. **Un código JavaScript modular** con funciones bien definidas
4. **Validaciones robustas** que previenen movimientos inválidos
5. **Una experiencia de usuario fluida** con feedback visual apropiado

### 4.2 Aprendizajes Clave

- **HTML5 Drag and Drop API**: Implementación y limitaciones en móviles
- **Event Handling en JavaScript**: Gestión de múltiples tipos de eventos
- **DOM Manipulation**: Creación dinámica de elementos y actualización eficiente
- **CSS Responsive Design**: Media queries y diseño adaptativo
- **Bootstrap Framework**: Uso de grid system y componentes

### 4.3 Posibles Mejoras Futuras

**Funcionalidad**

- [ ] Sistema de puntuación basado en tiempo y movimientos
- [ ] Niveles de dificultad seleccionables
- [ ] Sistema de deshacer movimientos (undo)
- [ ] Pistas automáticas para el siguiente movimiento
- [ ] Guardar partidas en localStorage

**Interfaz**

- [ ] Animaciones al mover cartas (CSS transitions/animations)
- [ ] Efectos de sonido al mover cartas
- [ ] Temas visuales personalizables
- [ ] Tutorial interactivo para nuevos jugadores

**Técnico**

- [ ] Implementar touch events nativos para móviles
- [ ] Optimizar rendimiento con virtual DOM
- [ ] Añadir tests unitarios
- [ ] Mejorar accesibilidad (ARIA labels, navegación por teclado)
- [ ] Progressive Web App (PWA) con funcionamiento offline

**Características Avanzadas**

- [ ] Multijugador online
- [ ] Tabla de clasificación global
- [ ] Modo torneo con tiempo límite
- [ ] Estadísticas históricas del jugador

### 4.4 Reflexión Final

Este proyecto ha servido como una excelente práctica de desarrollo frontend, combinando HTML, CSS y JavaScript para crear una aplicación interactiva completa.

La implementación del diseño responsive ha demostrado la importancia de pensar en múltiples dispositivos desde el inicio del desarrollo, y el sistema dual de interacción (click + drag) muestra cómo adaptar la UX a las limitaciones de cada plataforma.

El uso de vanilla JavaScript (sin frameworks) ha permitido comprender a fondo los conceptos fundamentales de manipulación del DOM, event handling y gestión del estado de la aplicación.

---

## 5 - REFERENCIAS

### Documentación Oficial

- **Mozilla Developer Network (MDN)**  
  https://developer.mozilla.org  
  Documentación completa de HTML, CSS y JavaScript

- **Bootstrap 5.3**  
  https://getbootstrap.com/docs/5.3/  
  Framework CSS utilizado para el diseño responsive

- **Bootstrap Icons**  
  https://icons.getbootstrap.com/  
  Librería de iconos utilizada en la interfaz

### Recursos de Aprendizaje

- **HTML5 Drag and Drop API**  
  https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API  
  Implementación del sistema de arrastre de cartas

- **CSS Media Queries**  
  https://developer.mozilla.org/en-US/docs/Web/CSS/Media_Queries  
  Diseño responsive y adaptativo

- **JavaScript Event Handling**  
  https://developer.mozilla.org/en-US/docs/Web/API/Event  
  Gestión de eventos de usuario

- **DOM Manipulation**  
  https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model  
  Manipulación dinámica del árbol DOM

### Herramientas de Desarrollo

- **Visual Studio Code**  
  https://code.visualstudio.com/  
  Editor de código utilizado

- **Live Server Extension**  
  https://marketplace.visualstudio.com/items?itemName=ritwickdey.LiveServer  
  Servidor de desarrollo local con recarga automática

- **Chrome DevTools**  
  https://developer.chrome.com/docs/devtools/  
  Herramientas de depuración y testing responsive

### Conceptos y Patrones

- **Responsive Web Design**  
  https://web.dev/responsive-web-design-basics/  
  Principios de diseño adaptativo

- **Event Delegation**  
  https://javascript.info/event-delegation  
  Patrón de delegación de eventos utilizado

- **CSS Flexbox**  
  https://css-tricks.com/snippets/css/a-guide-to-flexbox/  
  Sistema de layout utilizado en la mesa de juego

---

## ANEXOS

### A. Estructura de Datos

#### Carta (Objeto DOM)

```javascript
{
  tagName: "img",
  id: "carta-[numero]-[palo]",
  classList: ["carta"],
  dataset: {
    numero: "10",
    palo: "viu",
    color: "orange"
  },
  draggable: true/false
}
```

#### Configuración de Colores

```javascript
const PALO_COLOR = {
  viu: "orange",
  cua: "orange",
  hex: "grey",
  cir: "grey",
};
```

### B. Funciones Principales y su Propósito

| Función                          | Propósito                      | Parámetros             |
| -------------------------------- | ------------------------------ | ---------------------- |
| `comenzarJuego()`                | Inicializa una nueva partida   | Ninguno                |
| `generarMazo()`                  | Crea array de cartas           | Ninguno                |
| `barajar(mazo)`                  | Desordena cartas               | Array de elementos img |
| `cargarMazoInicial(mazo)`        | Carga cartas en tapete inicial | Array de elementos img |
| `arrancarTiempo()`               | Inicia cronómetro              | Ninguno                |
| `iniciaDrag(event)`              | Maneja inicio de arrastre      | Event                  |
| `cartaSoltada(event)`            | Procesa carta soltada          | Event                  |
| `mazoAceptaCarta(mazo, carta)`   | Valida movimiento              | Div mazo, Img carta    |
| `verificarJuegoTerminado()`      | Detecta victoria               | Ninguno                |
| `setContador(elemento, valor)`   | Actualiza contador visual      | Element, String/Number |
| `calcularContadorDeMazos(mazos)` | Actualiza contadores de cartas | Array de mazos         |
| `vaciarMazos()`                  | Limpia todos los mazos         | Ninguno                |
| `permitirDrop(event)`            | Permite soltar en zona         | Event                  |

### C. Comandos Útiles

#### Iniciar servidor local con Live Server

1. Instalar extensión Live Server en VS Code
2. Click derecho en `index.html` o `solitario.html`
3. Seleccionar "Open with Live Server"
4. El juego se abrirá en `http://127.0.0.1:5500`

#### Testear en dispositivo móvil real

1. Conectar PC y móvil a la misma red WiFi
2. Obtener IP del PC: `ipconfig` (Windows) o `ifconfig` (Mac/Linux)
3. En el móvil abrir: `http://[IP-DEL-PC]:5500`

---

**Autor**: [Tu Nombre]  
**Asignatura**: Frontend Development  
**Institución**: VIU - Universidad Internacional de Valencia  
**Fecha**: Enero 2026  
**Versión**: 1.0
