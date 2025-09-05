<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, CheckCircle, AlertCircle, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Rol } from '@/types';
import EditarRol from './editar.vue';
import CrearRol from './crear.vue';
import BorrarRol from './borrar.vue';

interface RolPageProps extends SharedData {
  rols: Rol[];
}

const { props } = usePage<RolPageProps>();
const rols = computed(() => props.rols);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Roles', href: '/roles' }];

// Variables para controlar los modales
const editingRol = ref<Rol | null>(null);
const creatingRol = ref<boolean>(false);
const deletingRol = ref<Rol | null>(null);

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
const editProveedor = (rol: Rol) => {
  editingRol.value = rol;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingRol.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (rol: Rol) => {
  deletingRol.value = rol;
};

// Función para refrescar los roles
const refreshRoles = () => {
  deletingRol.value = null;
  router.reload({ only: ['rols'] });
};

// Función para manejar el cierre del modal de creación
const handleCloseCreateModal = () => {
  creatingRol.value = false;
};

// Función para manejar la creación exitosa
const handleCreatedSuccess = () => {
  showNotification('Rol creado exitosamente!', 'success');
  creatingRol.value = false;
  setTimeout(() => {
    refreshRoles();
  }, 500);
};

// Función para manejar el cierre del modal de edición
const handleCloseEditModal = () => {
  editingRol.value = null;
};

// Función para manejar la actualización exitosa
const handleUpdatedSuccess = () => {
  showNotification('Rol actualizado exitosamente!', 'success');
  editingRol.value = null;
  setTimeout(() => {
    refreshRoles();
  }, 500);
};

// Función para manejar el cierre del modal de eliminación
const handleCloseDeleteModal = () => {
  deletingRol.value = null;
};

// Función para manejar la eliminación exitosa
const handleDeletedSuccess = () => {
  showNotification('Rol eliminado exitosamente!', 'success');
  deletingRol.value = null;
  setTimeout(() => {
    refreshRoles();
  }, 500);
};

// Función para manejar error en eliminación
const handleDeletedError = () => {
  showNotification('Error al eliminar el rol.', 'error');
  deletingRol.value = null;
};
</script>

<template>
  <Head title="Roles"/>
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
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Roles
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Roles</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Nombre</TableHead>
              <TableHead>Descripcion</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="rol in rols" :key="rol.Idrol">
              <TableCell class="font-medium">{{ rol.nombre }}</TableCell>
              <TableCell>{{ rol.descripcion }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editProveedor(rol)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(rol)"
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
    <EditarRol 
      v-if="editingRol" 
      :rol="editingRol"
      @close="handleCloseEditModal"
      @updated="handleUpdatedSuccess"
    />

    <!-- Modal de creación -->
    <CrearRol 
      v-if="creatingRol" 
      @close="handleCloseCreateModal"
      @created="handleCreatedSuccess"
    />

    <!-- Modal de eliminación -->
    <BorrarRol 
      v-if="deletingRol" 
      :rol="deletingRol"
      @close="handleCloseDeleteModal"
      @deleted="handleDeletedSuccess"
      @error="handleDeletedError"
    />
  </AppLayout>
</template>