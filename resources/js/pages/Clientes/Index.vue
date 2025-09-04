<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, User, Phone, Mail, CreditCard } from 'lucide-vue-next';
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
</script>

<template>
<Head title="Clientes"/>
<AppLayout>
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
      @close="editingCliente = null"
      @updated="refreshClientes"
    />

    <!-- Modal de creación -->
    <CrearCliente 
      v-if="creatingCliente" 
      @close="creatingCliente = false"
      @created="refreshClientes"
    />

    <!-- Modal de eliminación -->
    <BorrarCliente 
      v-if="deletingCliente" 
      :cliente="deletingCliente"
      @close="deletingCliente = null"
      @deleted="refreshClientes"
    />
</AppLayout>
</template>