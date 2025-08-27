<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
      <div class="p-6">
        <!-- Título del modal -->
        <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">Editar Producto</h2>
        </div>

        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Código de Barra -->
            <div>
              <label for="Codigo_barra" class="flex items-center text-sm font-medium text-foreground mb-2">
                Código de Barra *
              </label>
              <div class="relative">
                <input
                  id="Codigo_barra"
                  v-model="form.Codigo_barra"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  required
                  :class="{ 'border-destructive': form.errors.Codigo_barra }"
                />
                <ScanBarcode class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Codigo_barra" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Codigo_barra }}
              </div>
            </div>

            <!-- Nombre Producto -->
            <div>
              <label for="Nombre" class="flex items-center text-sm font-medium text-foreground mb-2">
                Nombre Producto *
              </label>
              <div class="relative">
                <input
                  id="Nombre"
                  v-model="form.Nombre"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  required
                  :class="{ 'border-destructive': form.errors.Nombre }"
                />
                <User class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Nombre" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Nombre }}
              </div>
            </div>

            <!-- Precio Costo -->
            <div>
              <label for="Precio_costo" class="flex items-center text-sm font-medium text-foreground mb-2">
                Precio Costo
              </label>
              <div class="relative">
                <input
                  id="Precio_costo"
                  v-model="form.Precio_costo"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_costo }"
                />
                <HandCoins class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_costo" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_costo }}
              </div>
            </div>

            <!-- Precio Regular -->
            <div>
              <label for="Precio_venta" class="flex items-center text-sm font-medium text-foreground mb-2">
                Precio Regular
              </label>
              <div class="relative">
                <input
                  id="Precio_venta"
                  v-model="form.Precio_venta"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_venta }"
                />
                <CircleDollarSign class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_venta" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_venta }}
              </div>
            </div>

            <!-- Precio Descuento -->
            <div>
              <label for="Precio_descuento" class="flex items-center text-sm font-medium text-foreground mb-2">
                Precio Descuento
              </label>
              <div class="relative">
                <input
                  id="Precio_descuento"
                  v-model="form.Precio_descuento"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_descuento }"
                />
                <CircleDollarSign class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_descuento" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_descuento }}
              </div>
            </div>

            <!-- Precio Mayorista -->
            <div>
              <label for="Precio_Mayorista" class="flex items-center text-sm font-medium text-foreground mb-2">
                Precio Mayorista
              </label>
              <div class="relative">
                <input
                  id="Precio_Mayorista"
                  v-model="form.Precio_Mayorista"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_Mayorista }"
                />
                <CircleDollarSign class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_Mayorista" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_Mayorista }}
              </div>
            </div>

            <!-- Unidad de Medida -->
            <div>
              <label for="Id_Medida" class="block text-sm font-medium text-foreground mb-2">Unidad de Medida</label>
              <select
                id="Id_Medida"
                v-model="form.Id_Medida"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Id_Medida }"
              >
                <option value="">Seleccionar Medida</option>
                <option v-for="medida in props.unidadmedidas" :key="medida.Id_Medida" :value="medida.Id_Medida">
                  {{ medida.Nombre_Medida }}
                </option>
              </select>
              <div v-if="form.errors.Id_Medida" class="text-destructive text-xs mt-1">{{ form.errors.Id_Medida }}</div>
            </div>

            <!-- Subcategoría -->
            <div>
              <label for="Idsubcat" class="block text-sm font-medium text-foreground mb-2">Subcategoría</label>
              <select
                id="Idsubcat"
                v-model="form.Idsubcat"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Idsubcat }"
              >
                <option value="">Seleccionar Subcategoría</option>
                <option v-for="subcategoria in props.subcategorias" :key="subcategoria.Idsubcat" :value="subcategoria.Idsubcat">
                  {{ subcategoria.Nombre_subcat }}
                </option>
              </select>
              <div v-if="form.errors.Idsubcat" class="text-destructive text-xs mt-1">{{ form.errors.Idsubcat }}</div>
            </div>

            <!-- Estado -->
            <div>
              <label for="Estado" class="block text-sm font-medium text-foreground mb-2">Estado</label>
              <select
                id="Estado"
                v-model="form.Estado"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Estado }"
              >
                <option value="">Seleccione estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              <div v-if="form.errors.Estado" class="text-destructive text-xs mt-1">{{ form.errors.Estado }}</div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-6 flex justify-end space-x-2">
            <Button type="button" variant="outline" @click="$emit('close')" class="px-4 flex items-center">
              <X class="h-4 w-4 mr-1" /> Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing" class="px-4 flex items-center">
              <template v-if="form.processing">
                <Loader2 class="h-4 w-4 mr-1 animate-spin" /> Guardando...
              </template>
              <template v-else>
                <Check class="h-4 w-4 mr-1" /> Guardar Cambios
              </template>
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
import { Building, User, HandCoins, CircleDollarSign, X, Check, Loader2, AlertCircle, ScanBarcode } from 'lucide-vue-next';
import type { Producto } from '@/types';
import type { Subcategoria } from '@/types';
import type { Unidadmedida } from '@/types';

const props = defineProps<{
  producto: Producto;
  subcategorias: Subcategoria[];
  unidadmedidas: Unidadmedida[];
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

const form = useForm({
  Codigo_barra: props.producto.Codigo_barra,
  Nombre: props.producto.Nombre,
  Precio_costo: props.producto.Precio_costo,
  Precio_venta: props.producto.Precio_venta,
  Precio_descuento: props.producto.Precio_descuento,
  Precio_Mayorista: props.producto.Precio_Mayorista,
  Id_Medida: props.producto.Id_Medida,
  Idsubcat: props.producto.Idsubcat,
  Estado: props.producto.Estado,
});

const submitForm = () => {
  form.put(`/productos/${props.producto.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated');
      emit('close');
    },
  });
};
</script>
