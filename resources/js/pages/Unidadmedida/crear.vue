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
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nueva Medida
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="nombre" class="block text-sm font-medium text-foreground mb-2">
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
              <span v-if="form.processing">Creando...</span>
              <span v-else>Crear Unidad Medida</span>
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
import { ref } from 'vue';
import { CheckCircle, AlertCircle, X } from 'lucide-vue-next';

// import { ref } from 'vue';
import { computed} from 'vue';
import type { Unidadmedida } from '@/types';

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created'): void;
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

// Formulario con datos iniciales vacíos
const form = useForm({
  Nombre_Medida: '',
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.post(route('Unidadmedida.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showNotification('Unidad Medida creado exitosamente!', 'success');
      
      // Esperar a que el toast se muestre antes de cerrar y recargar
      setTimeout(() => {
        emit('created');
        emit('close');
    window.location.reload();
      }, 2000);
    },
    onError: (errors) => {
      console.log('Errores del formulario:', errors);
      
      // Mostrar mensaje de error general si hay errores
      if (Object.keys(errors).length > 0) {
        showNotification('Error al crear la Unidad Medida. Revise los campos.', 'error');
      }
    },
  });
};
</script>