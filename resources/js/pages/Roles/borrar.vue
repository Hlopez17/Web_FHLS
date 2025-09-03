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
          <Button variant="destructive" @click="confirmDelete" :disabled="processing">
            <span v-if="processing">Eliminando...</span>
            <span v-else>Eliminar</span>
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { Rol } from '@/types';
import { ref } from 'vue';
import { CheckCircle, AlertCircle, X } from 'lucide-vue-next';

const props = defineProps<{ rol: Rol }>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted'): void;
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

// Estado para controlar el proceso de eliminación
const processing = ref(false);

// Función para confirmar la eliminación
const confirmDelete = async () => {
  processing.value = true;
  
  try {
    await router.delete(`/Rol/${props.rol.Idrol}`, {
      preserveScroll: true,
    onSuccess: () => {
      console.log('✅ Rol eliminado exitosamente - mostrando toast');
      showNotification('Rol eliminado exitosamente!', 'success');
      
      // Esperar a que el toast se muestre antes de cerrar y recargar
      setTimeout(() => {
        emit('deleted');
        emit('close');
        window.location.reload();
      }, 2000); // 2 segundos para ver el toast
    },
    onError: (errors) => {
      console.log('❌ Error al borrar rol - mostrando toast de error');
      showNotification('Error al borrar rol', 'error');
    }
    });
  } catch (error) {
    console.error('Error al eliminar rol:', error);
    processing.value = false;
  }
};
</script>
