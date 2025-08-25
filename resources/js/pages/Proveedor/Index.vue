<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Proveedor } from '@/types';
import Editar from './editar.vue';
import Crear from './crear.vue';
import Borrar from './borrar.vue';

interface ProveedorPageProps extends SharedData {
  proveedors: Proveedor[];
}
const { props } = usePage<ProveedorPageProps>();
const proveedors = computed(() => props.proveedors);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Proveedor', href: '/Proveedor' }];

// Variables para controlar los modales
const editingProveedor = ref<Proveedor | null>(null);
const creatingProveedor = ref<boolean>(false);
const deletingProveedor = ref<Proveedor | null>(null);

// Función para abrir el modal de edición
const editProveedor = (proveedor: Proveedor) => {
  editingProveedor.value = proveedor;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingProveedor.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (proveedor: Proveedor) => {
  deletingProveedor.value = proveedor;
};

// Función para refrescar los proveedores
const refreshProveedors = () => {
  router.reload({ only: ['proveedors'] });
};
</script>

<template>
<Head title="Proveedores"/>
<AppLayout>
 <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Proveedor
        </Button>
      </div>

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
            <TableRow v-for="proveedor in proveedors" :key="proveedor.id">
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

    <!-- Modal de edición -->
    <Editar 
      v-if="editingProveedor" 
      :proveedor="editingProveedor" 
      @close="editingProveedor = null"
      @updated="refreshProveedors"
    />

    <!-- Modal de creación -->
    <Crear 
      v-if="creatingProveedor" 
      @close="creatingProveedor = false"
      @created="refreshProveedors"
    />

    <!-- Modal de eliminación -->
    <Borrar 
      v-if="deletingProveedor" 
      :proveedor="deletingProveedor"
      @close="deletingProveedor = null"
      @deleted="refreshProveedors"
    />
</AppLayout>
</template>