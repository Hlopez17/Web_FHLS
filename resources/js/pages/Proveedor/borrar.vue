<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <!-- Ícono -->
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-destructive/10 mx-auto mb-4">
          <Trash2 class="h-6 w-6 text-destructive" />
        </div>
        
        <!-- Título -->
        <h2 class="text-xl font-semibold text-foreground text-center mb-2">
          ¿Eliminar Proveedor?
        </h2>
        
        <!-- Mensaje -->
        <p class="text-muted-foreground text-center mb-6">
          ¿Estás seguro de que deseas eliminar al proveedor 
          <span class="font-medium text-foreground">"{{ proveedor.Razon_social }}"</span>? 
          Esta acción no se puede deshacer.
        </p>

        <!-- Botones -->
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

  <!-- Toast -->
  <Transition name="fade">
    <div
      v-if="showToast"
      class="fixed top-6 right-6 z-50 px-4 py-2 rounded shadow-lg text-white text-sm"
      :class="{
        'bg-green-600': toastType === 'success',
        'bg-red-600': toastType === 'error'
      }"
    >
      {{ toastMessage }}
    </div>
  </Transition>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2 } from 'lucide-vue-next';
import type { Proveedor } from '@/types';

// Props
const props = defineProps<{ proveedor: Proveedor }>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted', msg:string, type:any): void;
}>();

// Estado de carga
const processing = ref(false);

// Toast
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  setTimeout(() => (showToast.value = false), 3000);
};

// Confirmar eliminación
const confirmDelete = async () => {
  processing.value = true;

  try {
    await router.delete(`/proveedores/${props.proveedor.Idproveedor}`, {
      preserveScroll: true,
      onSuccess: () => {
        emit('deleted', 'Proveedor eliminado correctamente', 'success');
        emit('close');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      },
      onError: (errors) => {
        emit('deleted', 'Ocurrió un error al eliminar la categoría', 'error');
        console.error('Error eliminando categoría:', errors);
        processing.value = false;
      },
      onFinish: () => {
        processing.value = false;
      }
    });
  } catch (error) {
    console.error('Error eliminando categoría:', error);
    showNotification('Error inesperado ❌', 'error');
    processing.value = false;
  }
};
</script>
