<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Unidadmedida} from '@/types';
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

// Función para refrescar los productos
const refreshmedidas = () => {
  router.reload({ only: ['unidadmedidas'] });
};
</script>

<template>
<Head title="Unidad Medida"/>
<AppLayout>
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
      @close="editingmedida = null"
      @updated="refreshmedidas"
    />

    <!-- Modal de creación -->
<Crearmedida 
  v-if="creatingmedida" 
  @close="creatingmedida = false"
  @created="refreshmedidas"
/>


<!-- Modal de eliminación -->
<Borrarmedida 
  v-if="deletingmedida" 
  :medida="deletingmedida"
  @close="deletingmedida = null"
  @deleted="refreshmedidas"
/>

</AppLayout>
</template>