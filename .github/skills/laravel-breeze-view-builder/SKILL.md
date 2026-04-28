# Laravel Blade Views Agent Skill

## Objetivo

Crear, modificar y mejorar vistas Blade para un proyecto Laravel, usando únicamente las tecnologías existentes del proyecto.

El agente debe trabajar con:
- Laravel 12
- Blade
- HTML
- CSS
- Vite
- Tailwind CSS solo si ya se usa en la vista o layout existente
- JavaScript vanilla solo si la vista lo requiere

No debe instalar ni proponer bibliotecas externas.

## Entradas que recibirá el agente

El usuario puede proporcionar:

- Nombre de la vista
- Ruta sugerida de la vista
- Contexto funcional
- Imagen o referencia visual
- Datos que debe mostrar
- Acciones disponibles
- Vista existente a modificar
- Layout o plantilla base del proyecto

## Reglas obligatorias

1. Antes de crear una vista nueva, revisar:
   - resources/views
   - resources/css/app.css
   - resources/js/app.js
   - routes/web.php
   - app/Http/Controllers
   - componentes Blade existentes
   - layouts existentes

2. No agregar dependencias nuevas.

3. No usar Bootstrap, DaisyUI, Alpine, Livewire, React, Vue ni librerías externas, salvo que ya estén claramente implementadas en el proyecto.

4. Usar HTML semántico.

5. Usar Blade correctamente:
   - @extends
   - @section
   - @yield
   - @include
   - @csrf
   - @method
   - @error
   - old()
   - route()
   - asset()
   - auth()
   - foreach / forelse / if

6. Mantener consistencia visual con las vistas existentes.

7. Si el proyecto usa layouts, la vista debe extender el layout existente.

8. Si existe un sistema de botones, tarjetas, tablas, formularios o navegación, reutilizar esas clases.

9. Para formularios:
   - Incluir @csrf
   - Incluir @method('PUT') o @method('PATCH') en edición
   - Mostrar errores de validación
   - Mantener valores con old()
   - Usar nombres de campos coherentes con la base de datos o modelo

10. Para tablas:
   - Usar diseño limpio
   - Mostrar estado vacío con @forelse
   - Agregar acciones de ver, editar o eliminar si el contexto lo pide
   - Confirmar eliminación con confirm() simple si no existe otro patrón

11. Para diseño:
   - Usar CSS propio o clases existentes
   - No crear estilos excesivos
   - Mantener una vista ordenada, centrada y responsiva
   - Evitar diseños complejos innecesarios

12. Si el usuario proporciona imagen:
   - Analizar estructura visual
   - Replicar distribución, jerarquía, espaciado y elementos principales
   - No copiar elementos que no tengan sentido funcional
   - Adaptar el diseño al estilo actual del proyecto

13. Si falta información, hacer una implementación razonable usando convenciones Laravel.

## Flujo de trabajo

Cuando el usuario pida una vista:

1. Identificar si es:
   - index
   - create
   - edit
   - show
   - dashboard
   - formulario personalizado
   - componente parcial

2. Revisar el proyecto para encontrar:
   - layout principal
   - estilos existentes
   - rutas
   - controlador relacionado
   - modelo relacionado
   - nombres reales de campos

3. Crear o modificar el archivo Blade.

4. Si hace falta, proponer cambios mínimos en:
   - routes/web.php
   - controlador
   - CSS existente

5. Entregar el código completo del archivo modificado.

6. Explicar brevemente dónde pegar cada archivo.

## Estilo esperado de respuesta

Responder siempre en español.

Usar este formato:

### Archivos a modificar

- ruta/del/archivo.blade.php
- ruta/del/controlador.php si aplica
- ruta/del/css.css si aplica

### Código

Incluir código completo y listo para copiar.

### Notas

Explicar solo lo necesario.

## Plantilla base para crear una vista Blade

Cuando no exista información suficiente del layout, usar una estructura compatible con Blade:

```blade
@extends('layouts.app')

@section('content')
<div class="page-container">
    <header class="page-header">
        <h1>{{ $title ?? 'Título de la vista' }}</h1>
        <p>Descripción breve de la sección.</p>
    </header>

    <section class="content-card">
        {{-- Contenido de la vista --}}
    </section>
</div>
@endsection