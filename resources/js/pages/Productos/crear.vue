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

    <!-- SOLO UN div principal para el modal -->
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
    <div class="p-6">
      <!-- Todo tu contenido del formulario va aquí -->
       <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">
            Crear Nuevo Producto
          </h2>
        </div>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Codigo_barra" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <ScanBarcode  class="h-4 w-4 mr-1" /> -->
                Código de Barra *
              </label>
              <div class="relative">
                <input
                  id="Codigo_barra"
                  v-model="form.Codigo_barra"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  required
                  :class="{ 'border-destructive': form.errors.Codigo_barra }"
                />
                <ScanBarcode  class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Codigo_barra" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Codigo_barra }}
              </div>
            </div>

            <div>
              <label for="Nombre" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <User class="h-4 w-4 mr-1" /> -->
                Nombre Producto *
              </label>
              <div class="relative">
                <input
                  id="Nombre"
                  v-model="form.Nombre"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
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

            <div>
              <label for="Precio_costo" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <HandCoins  class="h-4 w-4 mr-1" /> -->
                Precio Costo
              </label>
              <div class="relative">
                <input
                  id="Precio_costo"
                  v-model="form.Precio_costo"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_costo }"
                />
                <HandCoins  class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_costo" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_costo }}
              </div>
            </div>

             <!--PRECIOS VENTA--> 
            <div>
              <label for="Precio_venta" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <CircleDollarSign  class="h-4 w-4 mr-1" /> -->
                Precio Regular
              </label>
              <div class="relative">
                <input
                  id="Precio_venta"
                  v-model="form.Precio_venta"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_venta }"
                />
                <CircleDollarSign  class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_venta" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_venta }}
              </div>
            </div>

            <div>
              <label for="Precio_descuento" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <CircleDollarSign  class="h-4 w-4 mr-1" /> -->
                Precio Descuento
              </label>
              <div class="relative">
                <input
                  id="Precio_descuento"
                  v-model="form.Precio_descuento"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_descuento }"
                />
                <CircleDollarSign  class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_descuento" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_descuento }}
              </div>
            </div>

             <div>
              <label for="Precio_Mayorista" class="flex items-center text-sm font-medium text-foreground mb-2">
                <!-- <CircleDollarSign  class="h-4 w-4 mr-1" /> -->
                Precio Mayorista
              </label>
              <div class="relative">
                <input
                  id="Precio_Mayorista"
                  v-model="form.Precio_Mayorista"
                  type="number"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Precio_Mayorista }"
                />
                <CircleDollarSign  class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Precio_Mayorista" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Precio_Mayorista }}
              </div>
            </div>

             <div>
              <label for="Id_Medida" class="block text-sm font-medium text-foreground mb-2">
                Unidad de Medida
              </label>
              <select
                id="Id_Medida"
                v-model="form.Id_Medida"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors 
                      focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring 
                      disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Id_Medida }"
              >
                <option value="">Seleccionar Medida</option>
                <option 
                  v-for="medida in props.unidadmedidas" 
                  :key="medida.Id_Medida" 
                  :value="medida.Id_Medida"
                >
                  {{ medida.Nombre_Medida }}
                </option>
              </select>
              <div v-if="form.errors.Id_Medida" class="text-destructive text-xs mt-1">
                {{ form.errors.Id_Medida }}
              </div>
            </div>

            <div>
              <label for="Idsubcat" class="block text-sm font-medium text-foreground mb-2">
                Subcategoria
              </label>
              <select
                id="Idsubcat"
                v-model="form.Idsubcat"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors 
                      focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring 
                      disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Idsubcat }"
              >
                <option value="">Seleccionar Medida</option>
                <option 
                  v-for="subcategoria in props.subcategorias" 
                  :key="subcategoria.Idsubcat" 
                  :value="subcategoria.Idsubcat"
                >
                  {{ subcategoria.Nombre_subcat }}
                </option>
              </select>
              <div v-if="form.errors.Idsubcat" class="text-destructive text-xs mt-1">
                {{ form.errors.Idsubcat }}
              </div>
            </div>

            <div>
              <label for="Estado" class="block text-sm font-medium text-foreground mb-2">
                Estado
              </label>
                <select
                id="Estado"
                v-model="form.Estado"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Estado }"
                >
              <option value="">Seleccione estado</option>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
              </select>

              <div v-if="form.errors.Estado" class="text-destructive text-xs mt-1">
                {{ form.errors.Estado }}
              </div>
            </div>

            <!-- CATEGORIAS Y SUBCATEGORIAS-->
              <!-- <label for="Idcat">Categoría</label>
                <select
                  id="Idcat"
                  v-model="selectedCategoria"
                  class="border rounded px-2 py-1"
                >
                  <option value="">Seleccione categoría</option>
                  <option
                    v-for="cat in categorias"
                    :key="cat.Idcat"
                    :value="cat.Idcat"
                  >
                    {{ cat.Nombre_cat }}
                  </option>
                </select>

                <label for="Idsubcat">Subcategoría</label>
                <select
                  id="Idsubcat"
                  v-model="form.Idsubcat"
                  class="border rounded px-2 py-1"
                >
                  <option value="">Seleccione subcategoría</option>
                  <option
                    v-for="sub in subcategorias.filter(s => s.Idcat === selectedCategoria)"
                    :key="sub.Idsubcat"
                    :value="sub.Idsubcat"
                  >
                    {{ sub.Nombre_subcat }}
                  </option>
                </select> -->
            <!--FIN CATEGORIAS Y SUBCATEGORIAS -->

           


          </div>

          <div class="mt-6 flex justify-end space-x-2">
            <Button
              type="button"
              variant="outline"
              @click="$emit('close')"
              class="px-4 flex items-center"
            >
              <X class="h-4 w-4 mr-1" />
              Cancelar
            </Button>
            <Button
              type="submit"
              :disabled="form.processing"
              class="px-4 flex items-center"
            >
              <template v-if="form.processing">
                <Loader2 class="h-4 w-4 mr-1 animate-spin" />
                Creando...
              </template>
              <template v-else>
                <Check class="h-4 w-4 mr-1" />
                Crear Producto
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
// import { ref } from 'vue';
import { computed, ref } from 'vue';
import type { Producto } from '@/types';
import type { Categoria } from '@/types';
import type { Subcategoria } from '@/types';
import type { Unidadmedida } from '@/types';

import { 
  Building, User, HandCoins, CircleDollarSign, X, Check, 
  Loader2, AlertCircle, ScanBarcode, CheckCircle 
} from 'lucide-vue-next';


// Props
const props = defineProps<{
  subcategorias:Subcategoria[];
  unidadmedidas:Unidadmedida[];

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
// Estado local para guardar lo seleccionado
const selectedCategoria = ref<number | null>(null);
//

// Emits: eventos personalizados que el componente puede emitir
const emit = defineEmits<{
  (e: 'close'): void;    // Para cerrar el modal
  (e: 'created'): void;  // Para notificar que el proveedor fue creado
}>();

// Formulario con datos iniciales vacíos
const form = useForm({
  Codigo_barra: '',
  Nombre: '',
  Precio_costo: '',
  Precio_venta: '',
  Precio_descuento: '',
  Precio_Mayorista: '',
  Id_Medida: '',     // este sí conecta con tu combobox
  Idsubcat: '',      // este también conecta con tu combobox
  Estado: '',        // activo/inactivo
  foto: null,

});


// Función para enviar el formulario
const submitForm = () => {
  console.log('📤 Datos que voy a enviar:', form);
  form.post('/Producto', {
    preserveScroll: true,
onSuccess: () => {
  console.log('✅ Producto creado exitosamente - mostrando toast');
  showNotification('Producto creado exitosamente!', 'success');
  
  // Esperar a que el toast se muestre antes de cerrar y recargar
  setTimeout(() => {
    emit('created');
    emit('close');
    window.location.reload();
  }, 2000); // 2 segundos para ver el toast
    },
    onError: (errors) => {
      console.log('❌ Error al crear producto - mostrando toast de error');
      showNotification('Error al crear el producto', 'error');
    }
  });
};
</script>