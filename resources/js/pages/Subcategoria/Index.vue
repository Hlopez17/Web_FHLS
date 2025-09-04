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
</script>

<template>
  <Head title="Subcategorías"/>
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
      @updated="(msg, type) => { refreshSubcategorias(); showNotification(msg, type); }"
    />

    <!-- Modal de creación -->
    <CrearSubcategoria 
      v-if="creatingSubcategoria" 
      :categorias="categorias"
      @close="creatingSubcategoria = false"
      @created="(msg, type) => { refreshSubcategorias(); showNotification(msg, type); }"
    />

    <!-- Modal de eliminación -->
    <BorrarSubcategoria 
      v-if="deletingSubcategoria" 
      :subcategoria="deletingSubcategoria"
      @close="deletingSubcategoria = null"
      @deleted="(msg, type) => { refreshSubcategorias(); showNotification(msg, type); }"
    />
  </AppLayout>
</template>