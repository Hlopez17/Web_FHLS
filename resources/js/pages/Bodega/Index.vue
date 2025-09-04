<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Bodega, Sucursal } from '@/types';
import EditarBodega from './editar.vue';
import CrearBodega from './crear.vue';
import BorrarBodega from './borrar.vue';

interface BodegaPageProps extends SharedData {
  bodegas: Bodega[];
  sucursals: Sucursal[];
}

const { props } = usePage<BodegaPageProps>();
const bodegas = computed(() => props.bodegas);
const sucursals = computed(() => props.sucursals);

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Bodegas', href: '/Bodega' }
];

// Variables para controlar los modales
const editingBodega = ref<Bodega | null>(null);
const creatingBodega = ref<boolean>(false);
const deletingBodega = ref<Bodega | null>(null);

// Función para abrir el modal de edición
const editBodega = (bodega: Bodega) => {
  editingBodega.value = bodega;
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
  creatingBodega.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (bodega: Bodega) => {
  deletingBodega.value = bodega;
};

// Función para refrescar las subcategorías
const refreshSubcategorias = (msg:string, type:any) => {
  showNotification(msg, type)
  router.reload({ only: ['bodegas'] });
};
</script>

<template>
  <Head title="Bodega"/>
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
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Bodega
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Bodegas</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>ID</TableHead>
              <TableHead>Nombre Bodega</TableHead>
              <TableHead>Direccion</TableHead>
              <TableHead>Sucursal Padre</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow 
              v-for="bodega in bodegas" 
              :key="bodega.Idbodega"
            >
              <TableCell class="font-medium">
                {{ bodega.Idbodega }}
              </TableCell>
              <TableCell>
                {{ bodega.Nombre_bodega || 'Sin nombre' }}
              </TableCell>
              <TableCell>
                {{ bodega.Direccion || 'Sin nombre' }}
              </TableCell>
              <TableCell>
                {{ bodega.sucursal?.Nombre_Sucursal || 'Sin nombre' }}
              </TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editBodega(bodega)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(bodega)"
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
    <EditarBodega 
      v-if="editingBodega" 
      :bodega="editingBodega" 
      :sucursals="sucursals"
      @close="editingBodega = null"
      @updated="refreshSubcategorias"
    />

    <!-- Modal de creación -->
    <CrearBodega 
      v-if="creatingBodega" 
      :sucursals="sucursals"
      @close="creatingBodega = false"
      @created="refreshSubcategorias"
    />

    <!-- Modal de eliminación -->
    <BorrarBodega 
      v-if="deletingBodega" 
      :bodega="deletingBodega"
      @close="deletingBodega = null"
      @deleted="refreshSubcategorias"
    />
  </AppLayout>
</template>