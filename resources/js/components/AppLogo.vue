<script setup lang="ts">
// Importamos el componente del ícono del logo de la aplicación
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
  <!-- Contenedor del logo -->
  <div 
    class="flex aspect-square size-8 items-center justify-center 
           rounded-md bg-sidebar-primary text-sidebar-primary-foreground"
  >
    <!-- Ícono del logo con soporte para modo claro/oscuro -->
    <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
  </div>

  <!-- Contenedor del texto de la marca -->
  <div class="ml-1 grid flex-1 text-left text-sm">
    <!-- Nombre de la ferretería con estilo destacado -->
    <span class="mb-0.5 truncate leading-tight font-semibold">
      Ferretería Hodsong Luna
    </span>
  </div>
</template>
