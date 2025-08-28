<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus, User, Mail, Phone } from 'lucide-vue-next'; // Iconos
import { computed, ref } from 'vue';
import type { User as UserType } from '@/types';
import EditarUsuario from './editar.vue';
import CrearUsuario from './crear.vue';
import BorrarUsuario from './borrar.vue';

// Props que vienen desde Inertia (datos del servidor)
interface UserPageProps extends SharedData {
  users: UserType[]; // Lista de usuarios
  roles: any[];       // Lista de roles (ajusta el tipo según tu estructura)
}
const { props } = usePage<UserPageProps>();

// Computed: variables reactivas para usuarios y roles
const users = computed(() => props.users);
const roles = computed(() => props.roles || []);

// Breadcrumbs para la navegación
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Usuarios', href: '/usuarios' }];

// Variables para controlar los modales
const editingUser = ref<UserType | null>(null);  // Usuario que se está editando
const creatingUser = ref<boolean>(false);        // Modal de creación abierto o cerrado
const deletingUser = ref<UserType | null>(null); // Usuario que se quiere eliminar

// Función para abrir el modal de edición
const editUser = (user: UserType) => {
  editingUser.value = user;
};

// Función para abrir el modal de creación
const openCreateModal = () => {
  creatingUser.value = true;
};

// Función para abrir el modal de eliminación
const openDeleteModal = (user: UserType) => {
  deletingUser.value = user;
};

// Función para refrescar la lista de usuarios desde el servidor
const refreshUsers = () => {
  router.reload({ only: ['users'] }); // Solo recarga los datos de usuarios
};

// Función para obtener el nombre del rol de un usuario
// Función para obtener el nombre del rol a partir del Idrol
const getRoleName = (roleId: number | string | null) => {
  if (!roleId) return 'Sin rol';

  // Buscar el rol en la lista de roles
  const role = roles.value.find(r => Number(r.Idrol) === Number(roleId));

  // Devolver el nombre si existe, sino 'Sin rol'
  return role?.nombre || 'Sin rol';
};



// Función para formatear el estado de un usuario
const formatEstado = (estado: string | null) => {
  if (!estado) return 'Inactivo';
  return estado === 'Activo' ? 'Activo' : 'Inactivo';
};
</script>

<template>
<!-- Título de la página -->
<Head title="Usuarios"/>

<!-- Layout principal con sidebar -->
<AppLayout>
  <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

    <!-- Botón para abrir modal de creación de usuario -->
    <div class="flex">
      <Button
        size="sm"
        class="bg-indigo-600 hover:bg-indigo-700 text-white"
        @click="openCreateModal"
      >
        <CirclePlus class="w-4 h-4 mr-1" /> Crear Usuario
      </Button>
    </div>

    <!-- Tabla de usuarios -->
    <div class="relative min-h-[100vh] flex-1 rounded-xl border border-border">
      <Table>
        <TableCaption>Lista de Usuarios</TableCaption>
        <TableHeader>
          <TableRow>
            <TableHead>Nombre</TableHead>
            <TableHead>Email</TableHead>
            <TableHead>Teléfono</TableHead>
            <TableHead>Rol</TableHead>
            <TableHead>Estado</TableHead>
            <TableHead class="text-center">Acciones</TableHead>
          </TableRow>
        </TableHeader>

        <!-- Cuerpo de la tabla -->
        <TableBody>
          <TableRow v-for="user in users" :key="user.Idusuario">
            <!-- Nombre con icono -->
            <TableCell class="font-medium">
              <div class="flex items-center gap-2">
                <User class="h-4 w-4 text-muted-foreground" />
                {{ user.name }} {{ user.Apellido || '' }}
              </div>
            </TableCell>

            <!-- Email con icono -->
            <TableCell>
              <div class="flex items-center gap-2">
                <Mail class="h-4 w-4 text-muted-foreground" />
                {{ user.email }}
              </div>
            </TableCell>

            <!-- Teléfono con icono -->
            <TableCell>
              <div class="flex items-center gap-2">
                <Phone class="h-4 w-4 text-muted-foreground" />
                {{ user.Telefono || 'N/A' }}
              </div>
            </TableCell>

            <!-- Rol de usuario -->
            <TableCell>
            <span class="inline-flex items-center rounded-full bg-primary/10 px-2 py-1 text-xs font-medium text-primary">
              {{ getRoleName(user.Idrol) }}
            </span>
          </TableCell>



            <!-- Estado del usuario -->
            <TableCell>
              <span
                :class="{
                  'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium': true,
                  'bg-green-100 text-green-800': formatEstado(user.Estado) === 'Activo',
                  'bg-gray-100 text-gray-800': formatEstado(user.Estado) === 'Inactivo'
                }"
              >
                {{ formatEstado(user.Estado) }}
              </span>
            </TableCell>

            <!-- Botones de acción (editar / eliminar) -->
            <TableCell class="flex justify-center gap-2">
              <!-- Botón Editar -->
              <Button
                size="sm"
                variant="outline"
                class="h-8 w-8 p-0"
                @click="editUser(user)"
              >
                <Pencil class="h-4 w-4" />
              </Button>

              <!-- Botón Eliminar -->
              <Button
                size="sm"
                variant="outline"
                class="h-8 w-8 p-0 text-destructive hover:text-destructive hover:bg-destructive/10"
                @click="openDeleteModal(user)"
              >
                <Trash class="h-4 w-4" />
              </Button>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>

  <!-- Modal de edición de usuario -->
  <EditarUsuario
    v-if="editingUser"
    :user="editingUser"
    :roles="roles"
    @close="editingUser = null"
    @updated="refreshUsers"
  />

  <!-- Modal de creación de usuario -->
  <CrearUsuario
    v-if="creatingUser"
    :roles="roles"
    @close="creatingUser = false"
    @created="refreshUsers"
  />

  <!-- Modal de eliminación de usuario -->
  <BorrarUsuario
    v-if="deletingUser"
    :user="deletingUser"
    @close="deletingUser = null"
    @deleted="refreshUsers"
  />
</AppLayout>
</template>
