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

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingSucursal.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (sucursal: Sucursal) => {
  deletingSucursal.value = sucursal;
};

// Función para refrescar las categorías
const refreshSucursal = () => {
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
                  {{ countBodegas(sucursal) }} Bodega(s)
                </div>
              </TableCell>
              <TableCell>{{ sucursal.created_at ? new Date(sucursal.created_at).toLocaleDateString() : 'N/A' }}</TableCell>
              <TableCell>{{ sucursal.updated_at ? new Date(sucursal.updated_at).toLocaleDateString() : 'N/A' }}</TableCell>
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
      @updated="deletingSucursal"
    />

    <!-- Modal de creación -->
    <CrearSucursal 
      v-if="creatingSucursal" 
      @close="creatingSucursal = false"
      @created="deletingSucursal"
    />

    <!-- Modal de eliminación -->
    <BorrarSucursal 
      v-if="deletingSucursal" 
      :sucursal="deletingSucursal"
      @close="deletingSucursal = null"
      @deleted="deletingSucursal"
    />
</AppLayout>
</template>