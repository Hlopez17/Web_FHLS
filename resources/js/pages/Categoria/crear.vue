<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">

    <!-- Modal de creación -->
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nueva Categoría
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Nombre_cat" class="block text-sm font-medium text-foreground mb-2">
                Nombre de la Categoría *
              </label>
              <input
                id="Nombre_cat"
                v-model="form.Nombre_cat"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Nombre_cat }"
                placeholder="Ingrese el nombre de la categoría"
              />
              <div v-if="form.errors.Nombre_cat" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_cat }}
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
              <span v-else>Crear Categoría</span>
            </Button>
          </div>
        </form>
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
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { CheckCircle, AlertCircle, X } from 'lucide-vue-next';

// Toast states
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

// Función para mostrar el toast
const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;

  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string, type:any): void;
}>();

// Formulario
const form = useForm({
  Nombre_cat: '',
});

// Envío del formulario
const submitForm = () => {
  form.post('/categorias', {
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Categoría creada exitosamente!', 'success');
      emit('close');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    },
    onError: () => {
      showNotification('Error al crear la categoría', 'error');
    },
  });
};
</script>
