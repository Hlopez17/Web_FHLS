<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nueva bodega
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Nombre_bodega" class="block text-sm font-medium text-foreground mb-2">
                Nombre de la Bodega *
              </label>
              <input
                id="Nombre_subcat"
                v-model="form.Nombre_bodega"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Nombre_bodega }"
                placeholder="Ingrese el nombre de la Bodega"
              />
              <div v-if="form.errors.Nombre_bodega" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_bodega }}
              </div>
            </div>

            <div>
              <label for="Direccion" class="block text-sm font-medium text-foreground mb-2">
                Direccion de la Bodega *
              </label>
              <input
                id="Direccion"
                v-model="form.Direccion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Direccion }"
                placeholder="Ingrese la dirección de la Bodega"
              />
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1">
                {{ form.errors.Direccion }}
              </div>
            </div>

            <div>
              <label for="Idsucursal" class="block text-sm font-medium text-foreground mb-2">
                Sucursal *
              </label>
              <select
                id="Idsucursal"
                v-model="form.Idsucursal"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Idsucursal }"
              >
                <option value="">Seleccionar Sucursal</option>
                <option v-for="sucursal in sucursals" :key="sucursal.Idsucursal" :value="sucursal.Idsucursal">
                  {{ sucursal.Nombre_Sucursal || 'Sin nombre' }}
                </option>
              </select>
              <div v-if="form.errors.Idsucursal" class="text-destructive text-xs mt-1">
                {{ form.errors.Idsucursal }}
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
              <span v-else>Crear Bodega</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { Sucursal } from '@/types';

// Props
const props = defineProps<{
  sucursals: Sucursal[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string, type:any): void;
}>();

// Formulario con datos iniciales vacíos
const form = useForm({
  Nombre_bodega: '',
  Direccion: '',
  Idsucursal: '' as string | number,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  // Convertir Idsucursal a número (o null si está vacío)
  const formData = {
    Nombre_bodega: form.Nombre_bodega,
    Idsucursal: form.Idsucursal === '' ? null : Number(form.Idsucursal)
  };
  
  form.post('/Bodega', {
    data: formData,
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Bodega creada correctamente', 'success');
      emit('close');

      setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 1000);
    },
  });
};
</script>