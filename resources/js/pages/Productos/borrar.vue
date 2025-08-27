<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-destructive/10 mx-auto mb-4">
          <Trash2 class="h-6 w-6 text-destructive" />
        </div>
        
        <h2 class="text-xl font-semibold text-foreground text-center mb-2">
          ¿Eliminar Producto?
        </h2>
        
        <p class="text-muted-foreground text-center mb-6">
          ¿Estás seguro de que deseas eliminar al proveedor 
          <span class="font-medium text-foreground">"{{ producto.Nombre }}"</span>? 
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
            :disabled="processing"
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
import { Trash2 } from 'lucide-vue-next';
import type { Producto,Unidadmedida, Categoria, Subcategoria} from '@/types';

// Props: se recibe el proveedor que se va a eliminar
const props = defineProps<{
  producto: Producto;
}>();

// Emits: eventos personalizados que el componente puede emitir
const emit = defineEmits<{
  (e: 'close'): void;    // Para cerrar el modal
  (e: 'deleted'): void;  // Para notificar que el proveedor fue eliminado
}>();

// Estado para controlar el proceso de eliminación
const processing = ref(false);

// Función para confirmar la eliminación
const confirmDelete = async () => {
  processing.value = true;
  
  try {
    await router.delete(`/Producto/${props.producto.Idproducto}`, {
      preserveScroll: true,
      onSuccess: () => {
        emit('deleted');
        emit('close');
      },
      onError: (errors) => {
        console.error('Error eliminando Producto:', errors);
        processing.value = false;
      },
      onFinish: () => {
        processing.value = false;
      }
    });
  } catch (error) {
    console.error('Error eliminando Producto:', error);
    processing.value = false;
  }
};
</script>