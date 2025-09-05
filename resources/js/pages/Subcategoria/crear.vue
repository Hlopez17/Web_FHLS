<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nueva Subcategoría
        </h2>

        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Nombre -->
            <div>
              <label for="Nombre_subcat" class="block text-sm font-medium text-foreground mb-2">
                Nombre de la Subcategoría *
              </label>
              <input
                id="Nombre_subcat"
                v-model="form.Nombre_subcat"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Nombre_subcat }"
                placeholder="Ingrese el nombre de la subcategoría"
              />
              <div v-if="form.errors.Nombre_subcat" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_subcat }}
              </div>
            </div>

            <!-- Categoría -->
            <div>
              <label for="Idcategoria" class="block text-sm font-medium text-foreground mb-2">
                Categoría *
              </label>
              <select
                id="Idcategoria"
                v-model="form.Idcategoria"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Idcategoria }"
              >
                <option value="">Seleccionar categoría</option>
                <option v-for="categoria in categorias" :key="categoria.Idcategoria" :value="categoria.Idcategoria">
                  {{ categoria.Nombre_cat || 'Sin nombre' }}
                </option>
              </select>
              <div v-if="form.errors.Idcategoria" class="text-destructive text-xs mt-1">
                {{ form.errors.Idcategoria }}
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-6 flex justify-end space-x-2">
            <Button type="button" variant="outline" @click="$emit('close')" class="px-4">
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing" class="px-4">
              <span v-if="form.processing">Creando...</span>
              <span v-else>Crear Subcategoría</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast superior derecho -->
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
import { Button } from '@/components/ui/button';
import type { Categoria } from '@/types';
import { ref } from 'vue';

// Props
const props = defineProps<{
  categorias: Categoria[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string, type:any): void;
}>();

// Formulario
const form = useForm({
  Nombre_subcat: '',
  Idcategoria: '' as string | number,
});

// Toast
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

// Envío de formulario
const submitForm = () => {
  const formData = {
    Nombre_subcat: form.Nombre_subcat,
    Idcategoria: form.Idcategoria === '' ? null : Number(form.Idcategoria)
  };

  form.post('/Subcategoria', {
    data: formData,
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Subcategoría creada exitosamente!', 'success');
      emit('close');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    },
    onError: () => {
      showNotification('Error al crear la subcategoría ❌', 'error');
    }
  });
};
</script>
