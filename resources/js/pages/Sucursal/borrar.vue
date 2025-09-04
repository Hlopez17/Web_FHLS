<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-destructive/10 mx-auto mb-4">
          <Trash2 class="h-6 w-6 text-destructive" />
        </div>
        
        <h2 class="text-xl font-semibold text-foreground text-center mb-2">
          ¿Eliminar Sucursal?
        </h2>
        
        <!-- Validación de bodegas asociadas -->
        <div 
          v-if="sucursal.bodegas && sucursal.bodegas.length > 0" 
          class="bg-destructive/10 border border-destructive/20 rounded-md p-3 mb-4"
        >
          <AlertCircle class="h-5 w-5 text-destructive inline-block mr-2" />
          <span class="text-destructive text-sm font-medium">No se puede eliminar</span>
          <p class="text-destructive text-xs mt-1">
            Esta sucursal tiene {{ sucursal.bodegas.length }} bodega(s) asociada(s). 
            Debe eliminar primero las bodegas antes de poder eliminar esta sucursal.
          </p>
        </div>

        <!-- Mensaje normal si no tiene bodegas -->
        <p v-else class="text-muted-foreground text-center mb-6">
          ¿Estás seguro de que deseas eliminar la sucursal 
          <span class="font-medium text-foreground">"{{ sucursal.Nombre_Sucursal || 'Sin nombre' }}"</span>? 
          Esta acción no se puede deshacer.
        </p>

        <div class="flex justify-center space-x-3">
          <Button
            type="button"
            variant="outline"
            @click="$emit('close')"
            class="px-6"
            :disabled="processing"
          >
            Cancelar
          </Button>
          <Button
            type="button"
            variant="destructive"
            @click="confirmDelete"
            class="px-6"
            :disabled="processing || (sucursal.bodegas && sucursal.bodegas.length > 0)"
          >
            <span v-if="processing">Eliminando...</span>
            <span v-else>Eliminar</span>
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, AlertCircle } from 'lucide-vue-next';
import type { Sucursal } from '@/types';

// Props
const props = defineProps<{
  sucursal: Sucursal & { bodegas?: any[] }; // 👈 agregamos bodegas asociadas
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted', msg:string, type:any): void;
}>();

// Estado para controlar el proceso de eliminación
const processing = ref(false);

// Función para confirmar la eliminación
const confirmDelete = async () => {
  // Verificar si tiene bodegas asociadas
  if (props.sucursal.bodegas && props.sucursal.bodegas.length > 0) {
    return;
  }

  processing.value = true;
  
  try {
    await router.delete(`/Sucursal/${props.sucursal.Idsucursal}`, {
      preserveScroll: true,
      onSuccess: () => {
        emit('deleted', 'Sucursal eliminada correctamente', 'success');
        emit('close');

        setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 1000);
      },
      onError: (errors) => {
        emit('deleted', 'Ocurrió un error al eliminar la sucursal', 'error');
        console.error('Error eliminando sucursal:', errors);
        processing.value = false;
      },
      onFinish: () => {
        processing.value = false;
      }
    });
  } catch (error) {
    console.error('Error eliminando sucursal:', error);
    processing.value = false;
  }
};
</script>
