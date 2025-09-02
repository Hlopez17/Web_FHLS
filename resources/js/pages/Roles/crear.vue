<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nuevo Rol
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="nombre" class="block text-sm font-medium text-foreground mb-2">
                Nombre del rol *
              </label>
              <input
                id="nombre"
                v-model="form.nombre"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.nombre }"
                placeholder="Ingrese el nombre de la categoría"
              />
              <div v-if="form.errors.nombre" class="text-destructive text-xs mt-1">
                {{ form.errors.nombre }}
              </div>
            </div>

            <div>
              <label for="descripcion" class="block text-sm font-medium text-foreground mb-2">
                Descripcion del rol *
              </label>
              <input
                id="descripcion"
                v-model="form.descripcion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.descripcion }"
                placeholder="Ingrese el nombre de la categoría"
              />
              <div v-if="form.errors.descripcion" class="text-destructive text-xs mt-1">
                {{ form.errors.descripcion }}
              </div>
            </div>

          </div>

          <div class="mt-6 flex justify-end space-x-2">
            <Button
              type="button"
              variant="outline"
              @click="$emit('close')"
              class="px-4"
            >
              Cancelar
            </Button>
            <Button
              type="submit"
              :disabled="form.processing"
              class="px-4"
            >
              <span v-if="form.processing">Creando...</span>
              <span v-else>Crear rol</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// import { ref } from 'vue';
import { computed, ref } from 'vue';
import type { Rol } from '@/types';

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created'): void;
}>();

// Formulario con datos iniciales vacíos
const form = useForm({
  nombre: '',
  descripcion: '',
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.post('/Rol', {
    preserveScroll: true,
    onSuccess: () => {
      emit('created');
      emit('close');
    },
  });
};
</script>