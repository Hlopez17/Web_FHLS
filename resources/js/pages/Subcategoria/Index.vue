<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Subcategoria, Categoria } from '@/types';
import EditarSubcategoria from './editar.vue';
import CrearSubcategoria from './crear.vue';
import BorrarSubcategoria from './borrar.vue';

interface SubcategoriaPageProps extends SharedData {
  subcategorias: Subcategoria[];
  categorias: Categoria[];
}

const { props } = usePage<SubcategoriaPageProps>();
const subcategorias = computed(() => props.subcategorias);
const categorias = computed(() => props.categorias);

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Subcategorías', href: '/subcategorias' }
];

// Variables para controlar los modales
const editingSubcategoria = ref<Subcategoria | null>(null);
const creatingSubcategoria = ref<boolean>(false);
const deletingSubcategoria = ref<Subcategoria | null>(null);

// Función para abrir el modal de edición
const editSubcategoria = (subcategoria: Subcategoria) => {
  editingSubcategoria.value = subcategoria;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingSubcategoria.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (subcategoria: Subcategoria) => {
  deletingSubcategoria.value = subcategoria;
};

// Función para refrescar las subcategorías
const refreshSubcategorias = () => {
  router.reload({ only: ['subcategorias'] });
};
</script>

<template>
  <Head title="Subcategorías"/>
  <AppLayout>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Subcategoría
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Subcategorías</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>ID</TableHead>
              <TableHead>Nombre</TableHead>
              <TableHead>Fecha Creación</TableHead>
              <TableHead>Fecha Actualización</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow 
              v-for="subcategoria in subcategorias" 
              :key="subcategoria.Idsubcat"
            >
              <TableCell class="font-medium">
                {{ subcategoria.Idsubcat }}
              </TableCell>
              <TableCell>
                {{ subcategoria.Nombre_subcat || 'Sin nombre' }}
              </TableCell>
              <TableCell>
                {{ subcategoria.created_at ? new Date(subcategoria.created_at).toLocaleDateString() : 'N/A' }}
              </TableCell>
              <TableCell>
                {{ subcategoria.updated_at ? new Date(subcategoria.updated_at).toLocaleDateString() : 'N/A' }}
              </TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editSubcategoria(subcategoria)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(subcategoria)"
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
    <EditarSubcategoria 
      v-if="editingSubcategoria" 
      :subcategoria="editingSubcategoria" 
      :categorias="categorias"
      @close="editingSubcategoria = null"
      @updated="refreshSubcategorias"
    />

    <!-- Modal de creación -->
    <CrearSubcategoria 
      v-if="creatingSubcategoria" 
      :categorias="categorias"
      @close="creatingSubcategoria = false"
      @created="refreshSubcategorias"
    />

    <!-- Modal de eliminación -->
    <BorrarSubcategoria 
      v-if="deletingSubcategoria" 
      :subcategoria="deletingSubcategoria"
      @close="deletingSubcategoria = null"
      @deleted="refreshSubcategorias"
    />
  </AppLayout>
</template>