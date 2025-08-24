<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue'; 

import { type BreadcrumbItem, type SharedData } from '@/types';
import { Head, usePage, Link, router } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, CirclePlus } from 'lucide-vue-next';

import { computed } from 'vue';//De acá para arriba copiar todo
import type { Proveedor } from '@/types';


interface ProveedorPageProps extends SharedData {
  proveedors: Proveedor[]; //proveedors es el nombre de la tabla en la base de datos y Proveedor el nombre del modelo
}
const { props } = usePage<ProveedorPageProps>();
const proveedors = computed(() => props.proveedors);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Proveedor', href: '/Proveedor' }];

//Eliminar Proveedor
// const deleteEmployee = async (id: number) => {
//   if (!window.confirm('Are you sure you want to delete this employee?')) return;
//   router.delete(`/employees/${id}`, {
//     preserveScroll: true,
//     onSuccess: () => {
//       router.visit('/employees', { replace: true });
//     },
//     onError: (errors) => {
//       console.error('Error deleting employee:', errors);
//     }
//   });
// };

</script>

<template>
<Head title="Proveedores"/>
<AppLayout>
 <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size="sm" class="bg-indigo-500 hover:bg-indigo-700 text-white">
          <Link href="/Proveedor/create">
            <CirclePlus /> Crear Proveedor
          </Link>
        </Button>
      </div>

      <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
        <Table>
          <TableCaption>Lista Proveedores</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead>Razon Social</TableHead>
              <TableHead>Telefono</TableHead>
              <TableHead>Dirección</TableHead>
              <TableHead>Correo</TableHead>
              <TableHead class="text-center">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="Proveedor in proveedors" :key="Proveedor.id">
              <TableCell class="font-medium">{{ Proveedor.Razon_social }}</TableCell>
              <TableCell>{{ Proveedor.Telefono ?? 'N/A' }}</TableCell>
              <TableCell>{{ Proveedor.Direccion }}</TableCell>
              <TableCell>{{ Proveedor.Correo }}</TableCell>
              <!-- <TableCell class="text-right">
                {{ new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(Proveedor.Telefono) }}
              </TableCell> -->
              <TableCell class="flex justify-center gap-2">
                <Button as-child size="sm" class="bg-blue-500 hover:bg-blue-700 text-white">
                  <Link :href="`/employees/${Proveedor.id}/edit`">
                    <Pencil />
                  </Link>
                </Button>
                <Button size="sm" class="bg-rose-500 hover:bg-rose-700 text-white" @click="deleteEmployee(Proveedor.id)">
                  <Trash />
                </Button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
</AppLayout>
</template>