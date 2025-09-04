<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, CheckCircle, AlertCircle, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Unidadmedida } from '@/types';
import Editarmedida from './editar.vue';
import Crearmedida from './crear.vue';
import Borrarmedida from './borrar.vue';

interface medidasPageProps extends SharedData {
  unidadmedidas: Unidadmedida[];
}

const { props } = usePage<medidasPageProps>();
const unidadmedidas = computed(() => props.unidadmedidas);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Unidad Medida', href: '/Unidadmedida' }];

// Variables para controlar los modales
const editingmedida = ref<Unidadmedida | null>(null);
const creatingmedida = ref<boolean>(false);
const deletingmedida = ref<Unidadmedida | null>(null);

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
const editmedida = (medida: Unidadmedida) => {
  editingmedida.value = medida;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingmedida.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (medida: Unidadmedida) => {
  deletingmedida.value = medida;
};

// Función para refrescar las medidas
const refreshmedidas = () => {
  router.reload({ only: ['unidadmedidas'] });
};

// Función para manejar el cierre del modal de creación
const handleCloseCreateModal = () => {
  creatingmedida.value = false;
};

// Función para manejar la creación exitosa
const handleCreatedSuccess = () => {
  showNotification('Unidad de Medida creada exitosamente!', 'success');
  creatingmedida.value = false;
  setTimeout(() => {
    refreshmedidas();
  }, 500);
};

// Función para manejar el cierre del modal de edición
const handleCloseEditModal = () => {
  editingmedida.value = null;
};

// Función para manejar la actualización exitosa
const handleUpdatedSuccess = () => {
  showNotification('Unidad de Medida actualizada exitosamente!', 'success');
  editingmedida.value = null;
  setTimeout(() => {
    refreshmedidas();
  }, 500);
};

// Función para manejar el cierre del modal de eliminación
const handleCloseDeleteModal = () => {
  deletingmedida.value = null;
};

// Función para manejar la eliminación exitosa
const handleDeletedSuccess = () => {
  showNotification('Unidad de Medida eliminada exitosamente!', 'success');
  deletingmedida.value = null;
  setTimeout(() => {
    refreshmedidas();
  }, 500);
};

// Función para manejar error en eliminación
const handleDeletedError = () => {
  showNotification('Error al eliminar la Unidad de Medida.', 'error');
  deletingmedida.value = null;
};
</script>

<template>
  <Head title="Unidad Medida"/>
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
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Nueva Medida
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Unidades de Medida</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Id</TableHead>
              <TableHead>Nombre</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="medida in unidadmedidas" :key="medida.Id_Medida">
              <TableCell class="font-medium">{{ medida.Id_Medida }}</TableCell>
              <TableCell>{{ medida.Nombre_Medida }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editmedida(medida)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(medida)"
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
    <Editarmedida 
      v-if="editingmedida" 
      :medida="editingmedida"
      @close="handleCloseEditModal"
      @updated="handleUpdatedSuccess"
    />

    <!-- Modal de creación -->
    <Crearmedida 
      v-if="creatingmedida" 
      @close="handleCloseCreateModal"
      @created="handleCreatedSuccess"
    />

    <!-- Modal de eliminación -->
    <Borrarmedida 
      v-if="deletingmedida" 
      :medida="deletingmedida"
      @close="handleCloseDeleteModal"
      @deleted="handleDeletedSuccess"
      @error="handleDeletedError"
    />
  </AppLayout>
</template>