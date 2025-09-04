<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, List } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Sucursal } from '@/types';
import EditarSucursal from './editar.vue';
import CrearSucursal from './crear.vue';
import BorrarSucursal from './borrar.vue';

interface SucursalPageProps extends SharedData {
  sucursals: Sucursal[];
}
const { props } = usePage<SucursalPageProps>();
const sucursals = computed(() => props.sucursals);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Sucursales', href: '/Sucursal' }];

// Variables para controlar los modales
const editingSucursal = ref<Sucursal | null>(null);
const creatingSucursal = ref<boolean>(false);
const deletingSucursal = ref<Sucursal | null>(null);

// Función para abrir el modal de edición
const editSucursal = (sucursal: Sucursal) => {
  editingSucursal.value = sucursal;
};

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

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingSucursal.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (sucursal: Sucursal) => {
  deletingSucursal.value = sucursal;
};

// Función para refrescar las categorías
const refreshSucursal = (msg:string, type:any) => {
  showNotification(msg, type)
  router.reload({ only: ['sucursals'] });
};

// Función para contar Bodegas
const countBodegas = (sucursal: Sucursal) => {
  return sucursal.bodega ? sucursal.bodega.length : 0;
};
</script>

<template>
<Head title="Sucursal"/>
<AppLayout>
 <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

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

      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Nueva Sucursal
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Sucursales</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>ID</TableHead>
              <TableHead>Sucursal</TableHead>
              <TableHead>Direccion</TableHead>
              <TableHead>Gerente</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="sucursal in sucursals" :key="sucursal.Idsucursal">
              <TableCell class="font-medium">{{ sucursal.Idsucursal }}</TableCell>
              <TableCell>{{ sucursal.Nombre_Sucursal || 'Sin nombre' }}</TableCell>
              <TableCell>
                <div class="flex items-center gap-2">
                  <List class="h-4 w-4 text-muted-foreground" />
                  {{ sucursal.Direccion }} 
                </div>
              </TableCell>
              <TableCell>{{ sucursal.Gerente }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editSucursal(sucursal)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(sucursal)"
                  :disabled="countBodegas(sucursal) > 0"
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
    <EditarSucursal 
      v-if="editingSucursal" 
      :sucursal="editingSucursal" 
      @close="editingSucursal = null"
      @updated="refreshSucursal"
    />

    <!-- Modal de creación -->
    <CrearSucursal 
      v-if="creatingSucursal" 
      @close="creatingSucursal = false"
      @created="refreshSucursal"
    />

    <!-- Modal de eliminación -->
    <BorrarSucursal 
      v-if="deletingSucursal" 
      :sucursal="deletingSucursal"
      @close="deletingSucursal = null"
      @deleted="refreshSucursal"
    />
</AppLayout>
</template>