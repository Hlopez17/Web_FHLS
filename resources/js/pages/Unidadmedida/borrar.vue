<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-destructive mb-4">
          Eliminar Medida
        </h2>
        <p class="text-sm text-foreground mb-6">
          ¿Estás seguro de que deseas eliminar la medida 
          <span class="font-bold">{{ medida.Nombre_Medida }}</span>? 
          Esta acción no se puede deshacer.
        </p>

        <div class="flex justify-end space-x-2">
          <Button
            type="button"
            variant="outline"
            @click="$emit('close')"
          >
            Cancelar
          </Button>
          <Button
            type="button"
            class="bg-destructive text-white hover:bg-destructive/90"
            :disabled="form.processing"
            @click="deleteMedida"
          >
            <span v-if="form.processing">Eliminando...</span>
            <span v-else>Eliminar</span>
          </Button>
        </div>
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
  (e: 'deleted'): void;
}>();

const form = useForm({});

const deleteMedida = () => {
  form.delete(`/Medidas/${props.medida.Id_Medida}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('deleted');
      emit('close');
    },
  });
};
</script>
