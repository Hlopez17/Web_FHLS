<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, User, Phone, Mail, CreditCard, CheckCircle, AlertCircle, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Clientes } from '@/types';
import EditarCliente from './editar.vue';
import CrearCliente from './crear.vue';
import BorrarCliente from './borrar.vue';

interface ClientePageProps extends SharedData {
  clientes: Clientes[];
}
const { props } = usePage<ClientePageProps>();
const clientes = computed(() => props.clientes);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Clientes', href: '/clientes' }];

// Variables para controlar los modales
const editingCliente = ref<Cliente | null>(null);
const creatingCliente = ref<boolean>(false);
const deletingCliente = ref<Cliente | null>(null);

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
const editCliente = (cliente: Cliente) => {
  editingCliente.value = cliente;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingCliente.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (cliente: Cliente) => {
  deletingCliente.value = cliente;
};

// Función para refrescar los clientes
const refreshClientes = () => {
  router.reload({ only: ['clientes'] });
};

// Función para formatear moneda
const formatCurrency = (value: number | null) => {
  if (value === null || value === undefined) return 'L 0.00';
  return new Intl.NumberFormat('es-HN', {
    style: 'currency',
    currency: 'HNL'
  }).format(value);
};

// Función para verificar si se puede eliminar
const canDelete = (cliente: Cliente) => {
  // Verificar si tiene relaciones (esto debería venir del backend)
  return !cliente.facturas || cliente.facturas.length === 0;
};

// Función para manejar el cierre del modal de creación
const handleCloseCreateModal = () => {
  creatingCliente.value = false;
};

// Función para manejar la creación exitosa
const handleCreatedSuccess = () => {
  showNotification('Cliente creado exitosamente!', 'success');
  creatingCliente.value = false;
    refreshClientes();
};

// Función para manejar el cierre del modal de edición
const handleCloseEditModal = () => {
  editingCliente.value = null;
};

// Función para manejar la actualización exitosa
const handleUpdatedSuccess = () => {
  showNotification('Cliente actualizado exitosamente!', 'success');
  editingCliente.value = null;
  setTimeout(() => {
    refreshClientes();
  }, 500);
};

// Función para manejar el cierre del modal de eliminación
const handleCloseDeleteModal = () => {
  deletingCliente.value = null;
};

// Función para manejar la eliminación exitosa
const handleDeletedSuccess = () => {
  showNotification('Cliente eliminado exitosamente!', 'success');
  deletingCliente.value = null;
  setTimeout(() => {
    refreshClientes();
  }, 500);
};

// Función para manejar error en eliminación
const handleDeletedError = () => {
  showNotification('Error al eliminar el cliente.', 'error');
  deletingCliente.value = null;
};
</script>

<template>
  <Head title="Clientes"/>
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
          <CirclePlus class="w-4 h-4 mr-1" /> Nuevo Cliente
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Clientes</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Cédula</TableHead>
              <TableHead>Nombre</TableHead>
              <TableHead>Contacto</TableHead>
              <TableHead>Límite Crédito</TableHead>
              <TableHead>Saldo Crédito</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="cliente in clientes" :key="cliente.Idcliente">
              <TableCell class="font-medium">{{ cliente.Cedula || 'N/A' }}</TableCell>
              <TableCell>
                <div class="flex items-center gap-2">
                  <User class="h-4 w-4 text-muted-foreground" />
                  {{ cliente.Nombre }} {{ cliente.Apellido }}
                </div>
              </TableCell>
              <TableCell>
                <div class="space-y-1">
                  <div v-if="cliente.Telefono" class="flex items-center gap-2">
                    <Phone class="h-3 w-3 text-muted-foreground" />
                    <span class="text-sm">{{ cliente.Telefono }}</span>
                  </div>
                  <div v-if="cliente.Correo" class="flex items-center gap-2">
                    <Mail class="h-3 w-3 text-muted-foreground" />
                    <span class="text-sm">{{ cliente.Correo }}</span>
                  </div>
                </div>
              </TableCell>
              <TableCell>
                <div class="flex items-center gap-2">
                  <CreditCard class="h-4 w-4 text-muted-foreground" />
                  {{ formatCurrency(cliente.Limitecredito) }}
                </div>
              </TableCell>
              <TableCell>
                <div class="flex items-center gap-2">
                  <CreditCard class="h-4 w-4 text-muted-foreground" />
                  {{ formatCurrency(cliente.Saldocredito) }}
                </div>
              </TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editCliente(cliente)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(cliente)"
                  :disabled="!canDelete(cliente)"
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
    <EditarCliente 
      v-if="editingCliente" 
      :cliente="editingCliente" 
      @close="handleCloseEditModal"
      @updated="handleUpdatedSuccess"
    />

    <!-- Modal de creación -->
    <CrearCliente 
      v-if="creatingCliente" 
      @close="handleCloseCreateModal"
      @created="handleCreatedSuccess"
    />

    <!-- Modal de eliminación -->
    <BorrarCliente 
      v-if="deletingCliente" 
      :cliente="deletingCliente"
      @close="handleCloseDeleteModal"
      @deleted="handleDeletedSuccess"
      @error="handleDeletedError"
    />
  </AppLayout>
</template>