<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Proveedor } from '@/types';
import Editar from './editar.vue';
import Crear from './crear.vue';
import Borrar from './borrar.vue';


// Props desde Laravel
interface ProveedorPageProps extends SharedData {
  proveedors: Proveedor[];
}

const { props } = usePage<ProveedorPageProps>();
const proveedors = computed(() => props.proveedors);

// Mensajes flash locales
const localFlash = ref<string | null>(null);

// Variables para los modales
const editingProveedor = ref<Proveedor | null>(null);
const creatingProveedor = ref<boolean>(false);
const deletingProveedor = ref<Proveedor | null>(null);

// Abrir modales
const editProveedor = (proveedor: Proveedor) => { editingProveedor.value = proveedor; };
const openCreateModal = () => { creatingProveedor.value = true; };
const openDeleteModal = (proveedor: Proveedor) => { deletingProveedor.value = proveedor; };

// Refrescar proveedores
const refreshProveedors = () => {
  router.reload({ only: ['proveedors'] });
};

// Cuando se crea proveedor
const onCreated = (msg: string) => {
  localFlash.value = msg;
  setTimeout(() => (localFlash.value = null), 3000);
};

// Cuando se edita proveedor
const onUpdated = (msg: string) => {
  localFlash.value = msg;
  setTimeout(() => (localFlash.value = null), 3000);
};

// Cuando se elimina proveedor
const onDeleted = (msg: string) => {
  localFlash.value = msg;
  setTimeout(() => (localFlash.value = null), 3000);
  refreshProveedors();
};

const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;

  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

</script>

<template>
  <Head title="Proveedores"/>
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

      <!-- Mensajes locales -->
      <div v-if="localFlash" class="mb-2 p-3 rounded bg-green-100 text-green-800">
        {{ localFlash }}
      </div>

      <!-- Botón Crear -->
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Proveedor
        </Button>
      </div>

      <!-- Tabla -->
      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Proveedores</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Razón Social</TableHead>
              <TableHead>Teléfono</TableHead>
              <TableHead>Dirección</TableHead>
              <TableHead>Correo</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="proveedor in proveedors" :key="proveedor.Idproveedor">
              <TableCell class="font-medium">{{ proveedor.Razon_social }}</TableCell>
              <TableCell>{{ proveedor.Telefono ?? 'N/A' }}</TableCell>
              <TableCell>{{ proveedor.Direccion }}</TableCell>
              <TableCell>{{ proveedor.Correo }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editProveedor(proveedor)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(proveedor)"
                >
                  <Trash class="h-4 w-4" />
                </Button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>

    <!-- Modales -->
    <Editar 
      v-if="editingProveedor" 
      :proveedor="editingProveedor" 
      @close="editingProveedor = null"
      @updated="(msg, type) => { refreshProveedors(); showNotification(msg, type); }"
    />

    <Crear 
      v-if="creatingProveedor" 
      @close="creatingProveedor = false"
      @created="(msg, type) => { refreshProveedors(); showNotification(msg, type); }"
    />

    <Borrar 
      v-if="deletingProveedor" 
      :proveedor="deletingProveedor"
      @close="deletingProveedor = null"
      @deleted="(msg, type) => { refreshProveedors(); showNotification(msg, type); }"
    />
  </AppLayout>
</template>
