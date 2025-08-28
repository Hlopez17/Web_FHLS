<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <!-- Toast Notification -->
    <div v-if="showToast" :class="['fixed top-4 right-4 p-4 rounded-lg shadow-lg z-60 flex items-center transition-all duration-300', 
        toastType === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800']">
      <CheckCircle v-if="toastType === 'success'" class="h-5 w-5 mr-2" />
      <AlertCircle v-else class="h-5 w-5 mr-2" />
      <span>{{ toastMessage }}</span>
      <button @click="showToast = false" class="ml-4 text-gray-500 hover:text-gray-700">
        <X class="h-4 w-4" />
      </button>
    </div>
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
import { 
  Building, User, HandCoins, CircleDollarSign, X, Check, 
  Loader2, AlertCircle, ScanBarcode, CheckCircle 
} from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2 } from 'lucide-vue-next';
import type { Producto,Unidadmedida, Categoria, Subcategoria} from '@/types';

// Props: se recibe el proveedor que se va a eliminar
const props = defineProps<{
  producto: Producto;
}>();

// Estado para el toast
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

// Función para mostrar notificación
const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  
  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

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
      console.log('✅ Producto eliminado exitosamente - mostrando toast');
      showNotification('Producto eliminado exitosamente!', 'success');
      
      // Esperar a que el toast se muestre antes de cerrar y recargar
      setTimeout(() => {
        emit('deleted');
        emit('close');
        window.location.reload();
      }, 2000); // 2 segundos para ver el toast
    },
    onError: (errors) => {
      console.log('❌ Error al actualizar producto - mostrando toast de error');
      showNotification('Error al actualizar el producto', 'error');
    }
    });
  } catch (error) {
    console.error('Error eliminando Producto:', error);
    processing.value = false;
  }
};
</script>