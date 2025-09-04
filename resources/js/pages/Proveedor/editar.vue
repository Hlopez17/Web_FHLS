<template>
  <!-- Fondo oscuro y modal centrado -->
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <!-- Título -->
        <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">Editar Proveedor</h2>
        </div>

        <!-- Formulario -->
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Razón Social -->
            <div>
              <label for="razon_social" class="flex items-center text-sm font-medium text-foreground mb-2">
                <User class="h-4 w-4 mr-1" /> Razón Social *
              </label>
              <div class="relative">
                <input
                  id="razon_social"
                  v-model="form.Razon_social"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                  required
                  :class="{ 'border-destructive': form.errors.Razon_social }"
                />
                <User class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Razon_social" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" /> {{ form.errors.Razon_social }}
              </div>
            </div>

            <!-- Teléfono -->
            <div>
              <label for="telefono" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Phone class="h-4 w-4 mr-1" /> Teléfono
              </label>
              <div class="relative">
                <input
                  id="telefono"
                  v-model="form.Telefono"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                  :class="{ 'border-destructive': form.errors.Telefono }"
                />
                <Phone class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Telefono" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" /> {{ form.errors.Telefono }}
              </div>
            </div>

            <!-- Dirección -->
            <div>
              <label for="direccion" class="flex items-center text-sm font-medium text-foreground mb-2">
                <MapPin class="h-4 w-4 mr-1" /> Dirección
              </label>
              <div class="relative">
                <textarea
                  id="direccion"
                  v-model="form.Direccion"
                  rows="3"
                  class="flex w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-2 text-sm"
                  :class="{ 'border-destructive': form.errors.Direccion }"
                ></textarea>
                <MapPin class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" /> {{ form.errors.Direccion }}
              </div>
            </div>

            <!-- Correo -->
            <div>
              <label for="correo" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Mail class="h-4 w-4 mr-1" /> Correo Electrónico
              </label>
              <div class="relative">
                <input
                  id="correo"
                  v-model="form.Correo"
                  type="email"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                  :class="{ 'border-destructive': form.errors.Correo }"
                />
                <Mail class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <div v-if="form.errors.Correo" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" /> {{ form.errors.Correo }}
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-6 flex justify-end space-x-2">
            <Button type="button" variant="outline" @click="$emit('close')">
              <X class="h-4 w-4 mr-1" /> Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
              <template v-if="form.processing">
                <Loader2 class="h-4 w-4 mr-1 animate-spin" /> Guardando...
              </template>
              <template v-else>
                <Save class="h-4 w-4 mr-1" /> Guardar Cambios
              </template>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <Transition name="fade">
    <div
      v-if="showToast"
      class="fixed top-6 right-6 z-50 px-4 py-2 rounded shadow-lg text-white text-sm"
      :class="{
        'bg-green-600': toastType === 'success',
        'bg-red-600': toastType === 'error'
      }"
    >
      {{ toastMessage }}
    </div>
  </Transition>
</template>

<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
  Building,
  User,
  Phone,
  MapPin,
  Mail,
  X,
  Save,
  Loader2,
  AlertCircle
} from 'lucide-vue-next';
import type { Proveedor } from '@/types';

// Props
const props = defineProps<{ proveedor: Proveedor }>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'updated', msg:string, type:any): void;
}>();

// Formulario
const form = useForm({
  Razon_social: props.proveedor.Razon_social || '',
  Telefono: props.proveedor.Telefono || '',
  Direccion: props.proveedor.Direccion || '',
  Correo: props.proveedor.Correo || '',
});

// Toast
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  setTimeout(() => (showToast.value = false), 3000);
};

// Submit
const submitForm = () => {
  form.put(`/proveedores/${props.proveedor.Idproveedor}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated','Proveedor actualizado correctamente', 'success')
      emit('close')
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    },
    onError: () => {
      showNotification('Error al actualizar el proveedor ❌', 'error');
    },
  });
};
</script>
