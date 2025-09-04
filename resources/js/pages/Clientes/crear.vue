<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { User, Phone, Mail, CreditCard, IdCard } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created'): void;
}>();

const form = ref({
  Cedula: '',
  Nombre: '',
  Apellido: '',
  Telefono: '',
  Correo: '',
  Limitecredito: 0,
  Saldocredito: 0
});

const createCliente = () => {
  router.post('/clientes', form.value, {
    onSuccess: () => {
      emit('created');
      emit('close');
    }
  });
};
</script>

<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
      <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
        <User class="w-5 h-5" /> Crear Nuevo Cliente
      </h2>

      <div class="space-y-4">
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <IdCard class="w-4 h-4" /> Cédula *
          </label>
          <Input v-model="form.Cedula" placeholder="Ej: 0801-1985-12345" />
        </div>
        <div>
          <label class="text-sm font-medium">Nombre</label>
          <Input v-model="form.Nombre" placeholder="Nombre" />
        </div>
        <div>
          <label class="text-sm font-medium">Apellido</label>
          <Input v-model="form.Apellido" placeholder="Apellido" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <Phone class="w-4 h-4" /> Teléfono
          </label>
          <Input v-model="form.Telefono" placeholder="Teléfono" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <Mail class="w-4 h-4" /> Correo
          </label>
          <Input v-model="form.Correo" placeholder="correo@ejemplo.com" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <CreditCard class="w-4 h-4" /> Límite Crédito
          </label>
          <Input v-model="form.Limitecredito" type="number" placeholder="0.00" />
        </div>
        <div>
          <label class="text-sm font-medium flex items-center gap-1">
            <CreditCard class="w-4 h-4" /> Saldo Crédito
          </label>
          <Input v-model="form.Saldocredito" type="number" placeholder="0.00" />
        </div>
      </div>

      <div class="flex justify-end gap-3 mt-6">
        <Button variant="outline" @click="emit('close')">Cancelar</Button>
        <Button class="bg-indigo-600 text-white hover:bg-indigo-700" @click="createCliente">
          Crear
        </Button>
      </div>
    </div>
  </div>
</template>
