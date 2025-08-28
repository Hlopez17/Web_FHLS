<script setup lang="ts">
/**
 * Importación de layouts y componentes base
 */
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';

/**
 * Importación de componentes de UI (Tabla, Botones, etc.)
 */
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';

/**
 * Iconos de lucide
 */
import { Pencil, Trash, CirclePlus, List } from 'lucide-vue-next';

/**
 * Herramientas de Vue
 */
import { computed, ref } from 'vue';
import type { Categoria } from '@/types';

/**
 * Modales personalizados para CRUD
 */
import EditarCategoria from './editar.vue';
import CrearCategoria from './crear.vue';
import BorrarCategoria from './borrar.vue';

/**
 * Interfaz para las props que vienen de la página
 */
interface CategoriaPageProps extends SharedData {
  categorias: Categoria[];
}

// Props recibidas desde Inertia
const { props } = usePage<CategoriaPageProps>();

// Computed para acceder a la lista de categorías
const categorias = computed(() => props.categorias);

// Migas de pan (navegación superior)
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Categorías', href: '/categorias' }];

/**
 * Variables de estado para controlar la apertura de modales
 */
const editingCategoria = ref<Categoria | null>(null); // Categoría que se está editando
const creatingCategoria = ref<boolean>(false);        // Estado para abrir modal de creación
const deletingCategoria = ref<Categoria | null>(null);// Categoría que se quiere eliminar

/**
 * Función para abrir modal de edición
 */
const editCategoria = (categoria: Categoria) => {
  editingCategoria.value = categoria;
};

/**
 * Función para abrir modal de creación
 */
const openCreateModal = () => {
  creatingCategoria.value = true;
};

/**
 * Función para abrir modal de eliminación
 */
const openDeleteModal = (categoria: Categoria) => {
  deletingCategoria.value = categoria;
};

/**
 * Función para refrescar la lista de categorías desde el servidor
 */
const refreshCategorias = () => {
  router.reload({ only: ['categorias'] });
};

/**
 * Función para contar subcategorías de una categoría
 */
const countSubcategorias = (categoria: Categoria) => {
  return categoria.subcategoria ? categoria.subcategoria.length : 0;
};
</script>

<template>
  <!-- Título de la página -->
  <Head title="Categorías"/>

  <!-- Layout principal -->
  <AppLayout>
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

      <!-- Botón de crear nueva categoría -->
      <div class="flex">
        <Button 
          size="sm" 
          class="bg-indigo-600 hover:bg-indigo-700 text-white"
          @click="openCreateModal"
        >
          <CirclePlus class="w-4 h-4 mr-1" /> Crear Categoría
        </Button>
      </div>

      <!-- Tabla de categorías -->
      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
        <Table>
          <TableCaption>Lista de Categorías</TableCaption>
          
          <!-- Encabezados -->
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

          <!-- Filas dinámicas -->
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
              
              <!-- Acciones: Editar / Eliminar -->
              <TableCell class="flex justify-center gap-2">
                <!-- Botón editar -->
                <Button 
                  size="sm" 
                  variant="outline"
                  class="h-8 w-8 p-0"
                  @click="editCategoria(categoria)"
                >
                  <Pencil class="h-4 w-4" />
                </Button>

                <!-- Botón eliminar (deshabilitado si tiene subcategorías) -->
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
