<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, List } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { Categoria } from '@/types';
import EditarCategoria from './editar.vue';
import CrearCategoria from './crear.vue';
import BorrarCategoria from './borrar.vue';

interface CategoriaPageProps extends SharedData {
  categorias: Categoria[];
}
const { props } = usePage<CategoriaPageProps>();
const categorias = computed(() => props.categorias);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Categorías', href: '/categorias' }];

// Variables para controlar los modales
const editingCategoria = ref<Categoria | null>(null);
const creatingCategoria = ref<boolean>(false);
const deletingCategoria = ref<Categoria | null>(null);

// Función para abrir el modal de edición
const editCategoria = (categoria: Categoria) => {
  editingCategoria.value = categoria;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingCategoria.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (categoria: Categoria) => {
  deletingCategoria.value = categoria;
};

// Función para refrescar las categorías
const refreshCategorias = () => {
  router.reload({ only: ['categorias'] });
};

// Función para contar subcategorías
const countSubcategorias = (categoria: Categoria) => {
  return categoria.subcategorias ? categoria.subcategorias.length : 0;
};
</script>

<template>
<Head title="Categorías"/>
<AppLayout>
 <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Categoría
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Categorías</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>ID</TableHead>
              <TableHead>Nombre</TableHead>
              <TableHead>Subcategorías</TableHead>
              <TableHead>Fecha Creación</TableHead>
              <TableHead>Fecha Actualización</TableHead>
              <TableHead class="text-center">Acciones</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="categoria in categorias" :key="categoria.Idcategoria">
              <TableCell class="font-medium">{{ categoria.Idcategoria }}</TableCell>
              <TableCell>{{ categoria.Nombre_cat || 'Sin nombre' }}</TableCell>
              <TableCell>
                <div class="flex items-center gap-2">
                  <List class="h-4 w-4 text-muted-foreground" />
                  {{ countSubcategorias(categoria) }} subcategoría(s)
                </div>
              </TableCell>
              <TableCell>{{ categoria.created_at ? new Date(categoria.created_at).toLocaleDateString() : 'N/A' }}</TableCell>
              <TableCell>{{ categoria.updated_at ? new Date(categoria.updated_at).toLocaleDateString() : 'N/A' }}</TableCell>
              <TableCell class="flex justify-center gap-2">
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editCategoria(categoria)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                  @click="openDeleteModal(categoria)"
                  :disabled="countSubcategorias(categoria) > 0"
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
    <EditarCategoria 
      v-if="editingCategoria" 
      :categoria="editingCategoria" 
      @close="editingCategoria = null"
      @updated="refreshCategorias"
    />

    <!-- Modal de creación -->
    <CrearCategoria 
      v-if="creatingCategoria" 
      @close="creatingCategoria = false"
      @created="refreshCategorias"
    />

    <!-- Modal de eliminación -->
    <BorrarCategoria 
      v-if="deletingCategoria" 
      :categoria="deletingCategoria"
      @close="deletingCategoria = null"
      @deleted="refreshCategorias"
    />
</AppLayout>
</template>