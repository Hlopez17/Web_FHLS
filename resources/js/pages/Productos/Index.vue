<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, CheckCircle, AlertCircle, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Producto, Unidadmedida, Categoria, Subcategoria } from '@/types';
import EditarProd from './editar.vue';
import CrearProd from './crear.vue';
import BorrarProd from './borrar.vue';

interface ProductosPageProps extends SharedData {
  productos: Producto[];
  unidadmedidas: Unidadmedida[];
  categorias: Categoria[];
  subcategorias: Subcategoria[];
}

const { props } = usePage<ProductosPageProps>();
const productos = computed(() => props.productos);
const unidadmedidas = computed(() => props.unidadmedidas);
const categorias = computed(() => props.categorias);
const subcategorias = computed(() => props.subcategorias);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Producto', href: '/Producto' }];

// Variables para controlar los modales
const editingProducto = ref<Producto | null>(null);
const creatingProducto = ref<boolean>(false);
const deletingProducto = ref<Producto | null>(null);

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

// Función para abrir el modal de edición
const editProveedor = (producto: Producto) => {
  editingProducto.value = producto;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingProducto.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (producto: Producto) => {
  deletingProducto.value = producto;
};

// Función para refrescar los productos
const refreshProductos = () => {
  router.reload({ only: ['productos'] });
};

// Función para manejar el cierre del modal de creación
const handleCloseCreateModal = () => {
  creatingProducto.value = false;
};

// Función para manejar la creación exitosa
const handleCreatedSuccess = () => {
  showNotification('Producto creado exitosamente!', 'success');
  creatingProducto.value = false;
  setTimeout(() => {
    refreshProductos();
  }, 500);
};

// Función para manejar el cierre del modal de edición
const handleCloseEditModal = () => {
  editingProducto.value = null;
};

// Función para manejar la actualización exitosa
const handleUpdatedSuccess = () => {
  showNotification('Producto actualizado exitosamente!', 'success');
  editingProducto.value = null;
  setTimeout(() => {
    refreshProductos();
  }, 500);
};

// Función para manejar el cierre del modal de eliminación
const handleCloseDeleteModal = () => {
  deletingProducto.value = null;
};

// Función para manejar la eliminación exitosa
const handleDeletedSuccess = () => {
  showNotification('Producto eliminado exitosamente!', 'success');
  deletingProducto.value = null;
  setTimeout(() => {
    refreshProductos();
  }, 500);
};

// Función para manejar error en eliminación
const handleDeletedError = () => {
  showNotification('Error al eliminar el producto.', 'error');
  deletingProducto.value = null;
};
</script>

<template>
  <Head title="Productos"/>
  <AppLayout>
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
    
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Producto
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Productos</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Nombre</TableHead>
              <TableHead>Precio Costo</TableHead>
              <TableHead>Precio Regular</TableHead>
              <TableHead>Estado</TableHead>
              <TableHead>Subcategoria</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="producto in productos" :key="producto.Idproducto">
              <TableCell class="font-medium">{{ producto.Nombre }}</TableCell>
              <TableCell>{{ producto.Precio_costo }}</TableCell>
              <TableCell>{{ producto.Precio_venta }}</TableCell>
              <TableCell>{{ producto.Estado ?? 'N/A' }}</TableCell>
              <TableCell>{{ producto.subcategoria?.Nombre_subcat }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editProveedor(producto)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(producto)"
                >
                  <Trash class="h-4 w-4" />
                </Button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>

    <!-- Modal de edición -->
    <EditarProd 
      v-if="editingProducto" 
      :producto="editingProducto" 
      :unidadmedidas="unidadmedidas" 
      :subcategorias="subcategorias"
      @close="handleCloseEditModal"
      @updated="handleUpdatedSuccess"
    />

    <!-- Modal de creación -->
    <CrearProd 
      v-if="creatingProducto" 
      :unidadmedidas="unidadmedidas"
      :subcategorias="subcategorias"
      @close="handleCloseCreateModal"
      @created="handleCreatedSuccess"
    />

    <!-- Modal de eliminación -->
    <BorrarProd 
      v-if="deletingProducto" 
      :producto="deletingProducto"
      @close="handleCloseDeleteModal"
      @deleted="handleDeletedSuccess"
      @error="handleDeletedError"
    />
  </AppLayout>
</template>