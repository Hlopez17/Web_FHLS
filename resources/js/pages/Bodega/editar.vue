<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Bodega
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Nombre_bodega" class="block text-sm font-medium text-foreground mb-2">
                Nombre de la Bodega *
              </label>
              <input
                id="Nombre_bodega"
                v-model="form.Nombre_bodega"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Nombre_bodega }"
                placeholder="Ingrese el nombre de la bodega"
              />
              <div v-if="form.errors.Nombre_bodega" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_bodega }}
              </div>
            </div>

            <div>
              <label for="Direccion" class="block text-sm font-medium text-foreground mb-2">
                Dirección *
              </label>
              <input
                id="Direccion"
                v-model="form.Direccion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.Direccion }"
                placeholder="Ingrese la dirección de la bodega"
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
                required
                :class="{ 'border-destructive': form.errors.Idsucursal }"
              >
                <option value="">Seleccionar sucursal</option>
                <option 
                  v-for="sucursal in sucursals" 
                  :key="sucursal.Idsucursal" 
                  :value="sucursal.Idsucursal"
                >
                  {{ sucursal.Nombre_Sucursal || 'Sin nombre' }}
                </option>
              </select>
              <div v-if="form.errors.Idsucursal" class="text-destructive text-xs mt-1">
                {{ form.errors.Idsucursal }}
              </div>
            </div>

            <!-- Mostrar inventarios asociados si existen -->
            <div v-if="bodega.inventarios && bodega.inventarios.length > 0">
              <label class="block text-sm font-medium text-foreground mb-2">
                Inventarios asociados
              </label>
              <div class="bg-muted rounded-md p-3">
                <p class="text-sm text-muted-foreground mb-2">
                  Esta bodega tiene {{ bodega.inventarios.length }} inventario(s) asociado(s):
                </p>
                <ul class="text-sm space-y-1 max-h-20 overflow-y-auto">
                  <li v-for="inv in bodega.inventarios" :key="inv.Idinventario" class="flex items-center">
                    • {{ inv.Nombre_inventario || ('Inventario #' + inv.Idinventario) }}
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
import type { Bodega, Sucursal } from '@/types';

// Props
const props = defineProps<{
  bodega: Bodega & { inventarios?: any[] };
  sucursals: Sucursal[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

// Formulario con datos iniciales
const form = useForm({
  Nombre_bodega: props.bodega.Nombre_bodega || '',
  Direccion: props.bodega.Direccion || '',
  Idsucursal: props.bodega.Idsucursal,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.put(`/bodegas/${props.bodega.Idbodega}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated');
      emit('close');
    },
  });
};
</script>
