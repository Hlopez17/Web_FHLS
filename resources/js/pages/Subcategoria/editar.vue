<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Subcategoría
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
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

            <div v-if="subcategoria.productos && subcategoria.productos.length > 0">
              <label class="block text-sm font-medium text-foreground mb-2">
                Productos asociados
              </label>
              <div class="bg-muted rounded-md p-3">
                <p class="text-sm text-muted-foreground mb-2">
                  Esta subcategoría tiene {{ subcategoria.productos.length }} producto(s) asociado(s):
                </p>
                <ul class="text-sm space-y-1 max-h-20 overflow-y-auto">
                  <li v-for="producto in subcategoria.productos" :key="producto.Idproducto" class="flex items-center">
                    • {{ producto.Nombre }}
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
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { Subcategoria, Categoria } from '@/types';

// Props
const props = defineProps<{
  subcategoria: Subcategoria;
  categorias: Categoria[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

// Formulario con datos iniciales de la subcategoría
const form = useForm({
  Nombre_subcat: props.subcategoria.Nombre_subcat || '',
  Idcategoria: props.subcategoria.Idcategoria,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.put(`/subcategorias/${props.subcategoria.Idsubcat}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated');
      emit('close');
    },
  });
};
</script>