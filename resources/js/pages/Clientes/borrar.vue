<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Trash } from 'lucide-vue-next';
import type { Clientes } from '@/types';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  cliente: Clientes;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'deleted'): void;
  (e: 'error'): void;
}>();

// Función para manejar éxito
const handleSuccess = () => {
  // Emitir evento de eliminación exitosa
  emit('deleted');
  // Cerrar el modal inmediatamente
  emit('close');
        setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 3000);
};

// Función para manejar errores
const handleError = (errors: any) => {
  console.log('Errores al eliminar:', errors);
  
  // Emitir evento de error
  emit('error');
  // Cerrar el modal inmediatamente
  emit('close');
};

// Función para enviar el formulario al backend
const deleteCliente = () => {
  router.delete(`/Cliente/${props.cliente.Idcliente}`, {
    preserveScroll: true,
    onSuccess: handleSuccess,
    onError: handleError,
  });
};
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-red-100 rounded-full p-3">
          <Trash class="w-6 h-6 text-red-600" />
        </div>
      </div>
      <h2 class="text-lg font-semibold mb-2 text-red-600">¿Eliminar Cliente?</h2>
      <p class="mb-6">
        ¿Estás seguro de que deseas eliminar al cliente 
        <span class="font-bold">"{{ props.cliente.Nombre }} {{ props.cliente.Apellido }}"</span>?  
        Esta acción no se puede deshacer.
      </p>
      <div class="flex justify-center gap-3">
        <Button variant="outline" @click="emit('close')">Cancelar</Button>
        <Button class="bg-red-600 text-white hover:bg-red-700" @click="deleteCliente">
          Eliminar
        </Button>
      </div>
    </div>
  </div>
</template>