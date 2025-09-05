<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Medida
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Nombre_Medida" class="block text-sm font-medium text-foreground mb-2">
                Nombre de Medida *
              </label>
              <input
                id="Nombre_Medida"
                v-model="form.Nombre_Medida"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Nombre_Medida }"
                placeholder="Ingrese el nombre de la medida"
              />
              <div v-if="form.errors.Nombre_Medida" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_Medida }}
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
              <span v-if="form.processing">Actualizando...</span>
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
import type { Unidadmedida } from '@/types';

const props = defineProps<{
  medida: Unidadmedida;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

// Formulario con datos iniciales cargados
const form = useForm({
  Nombre_Medida: props.medida.Nombre_Medida,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.put(route('Unidadmedida.update', props.medida.Id_Medida), {
    preserveScroll: true,
    onSuccess: () => {
      // Emitir evento de actualización exitosa
      emit('updated');
      // Cerrar el modal inmediatamente
      emit('close');
      // Recargar la página después de 3 segundos
      setTimeout(() => {
        window.location.reload();
      }, 3000);
    },
    onError: (errors) => {
      console.log('Errores del formulario:', errors);
    },
  });
};
</script>