<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { User, Phone, Mail, CreditCard, IdCard } from 'lucide-vue-next';
import type { Clientes } from '@/types';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  cliente: Clientes;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated'): void;
}>();

const form = ref({ ...props.cliente });

// Función para manejar éxito
const handleSuccess = () => {
  // Emitir evento de actualización exitosa
  emit('updated');
  // Cerrar el modal inmediatamente
  emit('close');
        setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 3000);
};

// Función para manejar errores
const handleError = (errors: any) => {
  console.log('Errores del formulario:', errors);
  
  // Mostrar mensaje de error general si hay errores
  if (Object.keys(errors).length > 0) {
  }
};

// Función para enviar el formulario al backend
const updateCliente = () => {
  router.put(`/Cliente/${form.value.Idcliente}`, form.value, {
    preserveScroll: true,
    onSuccess: handleSuccess,
    onError: handleError,
  });
};
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
      <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
        <User class="w-5 h-5" /> Editar Cliente
      </h2>

      <div class="space-y-4">
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <IdCard class="w-4 h-4" /> Cédula
          </label>
          <Input v-model="form.Cedula" />
        </div>
        <div>
          <label class="text-sm font-medium">Nombre</label>
          <Input v-model="form.Nombre" />
        </div>
        <div>
          <label class="text-sm font-medium">Apellido</label>
          <Input v-model="form.Apellido" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <Phone class="w-4 h-4" /> Teléfono
          </label>
          <Input v-model="form.Telefono" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <Mail class="w-4 h-4" /> Correo
          </label>
          <Input v-model="form.Correo" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <CreditCard class="w-4 h-4" /> Límite Crédito
          </label>
          <Input type="number" v-model="form.Limitecredito" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <CreditCard class="w-4 h-4" /> Saldo Crédito
          </label>
          <Input type="number" v-model="form.Saldocredito" />
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <Button variant="outline" @click="emit('close')">Cancelar</Button>
        <Button class="bg-indigo-600 text-white hover:bg-indigo-700" @click="updateCliente">
          Guardar Cambios
        </Button>
      </div>
    </div>
  </div>
</template>