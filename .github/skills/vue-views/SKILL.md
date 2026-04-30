# Vue Views Agent Skill

## Objetivo

Crear, modificar y mejorar vistas Vue para un proyecto frontend, usando únicamente las tecnologías existentes del proyecto.

El agente debe trabajar con el stack real detectado en el proyecto, por ejemplo:
- Vue 3
- Vite
- JavaScript o TypeScript
- Vue Router si ya existe
- Pinia o store existente solo si ya está implementado
- CSS, SCSS, Tailwind o sistema de estilos ya presente
- Axios o cliente HTTP existente solo si ya está implementado

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
   - `src/views`
   - `src/pages`
   - `src/components`
   - `src/layouts`
   - `src/router`
   - `src/assets`
   - `src/styles`
   - `src/services`
   - `src/api`
   - `src/store`
   - `src/App.vue`
   - `src/main.js` o `src/main.ts`
   - `package.json`

2. No agregar dependencias nuevas.

3. No usar React, Angular, Nuxt, Vuetify, Bootstrap, DaisyUI, Tailwind, Pinia, Vuex u otras librerías externas, salvo que ya estén claramente implementadas en el proyecto.

4. Usar HTML semántico dentro de Vue.

5. Usar Vue correctamente según el proyecto:
   - API Options o Composition API, según ya exista
   - props
   - emits
   - computed
   - watch
   - métodos
   - manejo de estado local
   - directivas como `v-if`, `v-for`, `v-model`, `v-show`, `:class`, `@click`, `@submit.prevent`

6. Mantener consistencia visual con las vistas existentes.

7. Si el proyecto usa layouts o contenedores base, reutilizarlos.

8. Si existe un sistema de botones, tarjetas, tablas, formularios o navegación, reutilizar esas clases o componentes.

9. Para formularios:
   - Mantener estado claro del formulario
   - Mostrar errores de validación de forma visual
   - Mantener nombres de campos coherentes con la API o el dominio del negocio
   - Reutilizar componentes de input si ya existen

10. Para tablas o resultados:
   - Usar diseño limpio
   - Mostrar estado vacío cuando no haya datos
   - Mostrar loaders si el flujo lo requiere
   - Agregar acciones si el contexto lo pide

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

13. Si falta información, hacer una implementación razonable usando convenciones Vue y la estructura existente del proyecto.

## Flujo de trabajo

Cuando el usuario pida una vista:

1. Identificar si es:
   - index
   - create
   - edit
   - show
   - dashboard
   - lookup
   - formulario personalizado
   - componente visual
   - página conectada a API

2. Revisar el proyecto para encontrar:
   - layout principal
   - estilos existentes
   - router
   - servicios o cliente HTTP
   - componentes relacionados
   - nombres reales de campos
   - patrón de consumo de API

3. Crear o modificar el archivo Vue.

4. Si hace falta, proponer cambios mínimos en:
   - router
   - servicios
   - CSS existente
   - componentes auxiliares

5. Entregar el código completo del archivo modificado.

6. Explicar brevemente dónde pegar cada archivo.

## Estilo esperado de respuesta

Responder siempre en español.

Usar este formato:

### Archivos a modificar

- ruta/del/archivo.vue
- ruta/del/router.js si aplica
- ruta/del/service.js si aplica
- ruta/del/css.css si aplica

### Código

Incluir código completo y listo para copiar.

### Notas

Explicar solo lo necesario.

## Plantilla base para crear una vista Vue

Cuando no exista suficiente información del layout, usar una estructura simple y compatible con Vue:

```vue
<template>
  <div class="page-container">
    <header class="page-header">
      <h1>{{ title }}</h1>
      <p>{{ description }}</p>
    </header>

    <section class="content-card">
      <!-- Contenido principal -->
    </section>
  </div>
</template>

<script>
export default {
  name: 'BaseView',
  data() {
    return {
      title: 'Título de la vista',
      description: 'Descripción breve de la sección.',
    }
  },
}
</script>

<style scoped>
.page-container {
  padding: 24px;
}

.page-header {
  margin-bottom: 24px;
}

.content-card {
  padding: 24px;
  border-radius: 12px;
}
</style>