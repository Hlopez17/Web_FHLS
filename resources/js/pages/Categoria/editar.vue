<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Categoría
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

            <div v-if="categoria.subcategorias && categoria.subcategorias.length > 0">
              <label class="block text-sm font-medium text-foreground mb-2">
                Subcategorías asociadas
              </label>
              <div class="bg-muted rounded-md p-3">
                <p class="text-sm text-muted-foreground mb-2">
                  Esta categoría tiene {{ categoria.subcategorias.length }} subcategoría(s) asociada(s):
                </p>
                <ul class="text-sm space-y-1">
                  <li v-for="subcat in categoria.subcategorias" :key="subcat.Idsubcat" class="flex items-center">
                    • {{ subcat.Nombre_subcat }}
                  </li>
                </ul>
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
              <span v-if="form.processing">Guardando...</span>
              <span v-else>Guardar Cambios</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast en la parte superior derecha -->
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
import { router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { Categoria } from '@/types';
import { ref } from 'vue';

// Props
const props = defineProps<{
  categoria: Categoria;
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated', msg:string, type:any): void;
}>();

// Estado del toast
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

// Formulario con datos iniciales de la categoría
const form = useForm({
  Nombre_cat: props.categoria.Nombre_cat || '',
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.put(`/categoria/${props.categoria.Idcategoria}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated','Categoría actualizada correctamente', 'success')
      emit('close')
      setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 1000);
    },
    onError: () => {
      showNotification('Error al actualizar la categoría ❌', 'error');
    }
  });
};
</script>
