<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-destructive/10 mx-auto mb-4">
          <Trash2 class="h-6 w-6 text-destructive" />
        </div>

        <h2 class="text-xl font-semibold text-foreground text-center mb-2">
          ¿Eliminar Subcategoría?
        </h2>

        <!-- Alerta si tiene productos -->
        <div
          v-if="subcategoria.productos && subcategoria.productos.length > 0"
          class="bg-destructive/10 border border-destructive/20 rounded-md p-3 mb-4"
        >
          <AlertCircle class="h-5 w-5 text-destructive inline-block mr-2" />
          <span class="text-destructive text-sm font-medium">No se puede eliminar</span>
          <p class="text-destructive text-xs mt-1">
            Esta subcategoría tiene {{ subcategoria.productos.length }} producto(s) asociado(s).
            Debe eliminar primero los productos antes de poder eliminar esta subcategoría.
          </p>
        </div>

        <!-- Confirmación -->
        <p v-else class="text-muted-foreground text-center mb-6">
          ¿Estás seguro de que deseas eliminar la subcategoría
          <span class="font-medium text-foreground">"{{ subcategoria.Nombre_subcat || 'Sin nombre' }}"</span>?
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
            :disabled="processing || (subcategoria.productos && subcategoria.productos.length > 0)"
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
import { Trash2, AlertCircle } from 'lucide-vue-next';
import type { Subcategoria } from '@/types';

// Props
const props = defineProps<{
  subcategoria: Subcategoria;
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted', msg:string, type:any): void;
}>();

// Estado
const processing = ref(false);
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

// Función toast
const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

// Eliminar subcategoría
const confirmDelete = async () => {
  if (props.subcategoria.productos && props.subcategoria.productos.length > 0) {
    return;
  }

  processing.value = true;

  try {
    await router.delete(`/Subcategoria/${props.subcategoria.Idsubcat}`, {
      preserveScroll: true,
      onSuccess: () => {
        emit('deleted', 'Subcategoría eliminada correctamente', 'success');
        emit('close');
        setTimeout(() => {
          window.location.reload(); 
        }, 1000);
      },
      onError: (errors) => {
        emit('deleted', 'Ocurrió un error al eliminar la Subcategoría', 'error');
        console.error('Error eliminando Subcategoría:', errors);
        processing.value = false;
      },
      onFinish: () => {
        processing.value = false;
      }
    });
  } catch (error) {
    console.error('Error eliminando subcategoría:', error);
    processing.value = false;
    showNotification('Error inesperado al eliminar ❌', 'error');
  }
};
</script>
