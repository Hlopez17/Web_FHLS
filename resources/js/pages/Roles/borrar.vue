<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-sm">
      <div class="p-6 text-center">
        <h2 class="text-lg font-semibold text-foreground mb-4">
          ¿Eliminar este rol?
        </h2>
        <p class="text-sm text-muted-foreground mb-6">
          Esta acción no se puede deshacer. El rol <b>{{ rol.nombre }}</b> será eliminado permanentemente.
        </p>

        <div class="flex justify-center gap-3">
          <Button variant="outline" @click="$emit('close')">
            Cancelar
          </Button>
          <Button variant="destructive" @click="deleteRol" :disabled="form.processing">
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
import type { Rol } from '@/types';

const props = defineProps<{ rol: Rol }>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted'): void;
}>();

const form = useForm({});

const deleteRol = () => {
  form.delete(`/Rol/${props.rol.Idrol}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('deleted');
      emit('close');
    },
  });
};
</script>
