<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Rol} from '@/types';
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

// Función para refrescar los productos
const refreshRoles = () => {
  router.reload({ only: ['rols'] });
};
</script>

<template>
<Head title="Roles"/>
<AppLayout>
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
      @close="editingRol = null"
      @updated="refreshRoles"
    />

    <!-- Modal de creación -->
<CrearRol 
  v-if="creatingRol" 
  @close="creatingRol = false"
  @created="refreshRoles"
/>


<!-- Modal de eliminación -->
<BorrarRol 
  v-if="deletingRol" 
  :rol="deletingRol"
  @close="deletingRol = null"
  @deleted="refreshRoles"
/>

</AppLayout>
</template>