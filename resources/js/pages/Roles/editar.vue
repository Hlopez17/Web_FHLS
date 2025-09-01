<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Rol
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
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                required
                :class="{ 'border-destructive': form.errors.nombre }"
              />
              <div v-if="form.errors.nombre" class="text-destructive text-xs mt-1">
                {{ form.errors.nombre }}
              </div>
            </div>

            <div>
              <label for="descripcion" class="block text-sm font-medium text-foreground mb-2">
                Descripción del rol *
              </label>
              <input
                id="descripcion"
                v-model="form.descripcion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                required
                :class="{ 'border-destructive': form.errors.descripcion }"
              />
              <div v-if="form.errors.descripcion" class="text-destructive text-xs mt-1">
                {{ form.errors.descripcion }}
              </div>
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-2">
            <Button type="button" variant="outline" @click="$emit('close')">
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
              <span v-if="form.processing">Guardando...</span>
              <span v-else>Guardar cambios</span>
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
import type { Rol } from '@/types';

const props = defineProps<{ rol: Rol }>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

// Inicializamos el formulario con datos del rol
const form = useForm({
  nombre: props.rol.nombre,
  descripcion: props.rol.descripcion,
});

const submitForm = () => {
  form.put(`/Rol/${props.rol.Idrol}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated');
      emit('close');
    },
  });
};
</script>
