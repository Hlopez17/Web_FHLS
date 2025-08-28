<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">
            Crear Nuevo Proveedor
          </h2>
        </div>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Razón social -->
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
              </div>
              <div v-if="form.errors.Razon_social" class="text-destructive text-xs mt-1">
                {{ form.errors.Razon_social }}
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
              </div>
              <div v-if="form.errors.Telefono" class="text-destructive text-xs mt-1">
                {{ form.errors.Telefono }}
              </div>
            </div>

            <!-- Dirección -->
            <div>
              <label for="direccion" class="flex items-center text-sm font-medium text-foreground mb-2">
                <MapPin class="h-4 w-4 mr-1" /> Dirección
              </label>
              <textarea
                id="direccion"
                v-model="form.Direccion"
                rows="3"
                class="flex w-full rounded-md border border-input bg-transparent p-2 text-sm"
                :class="{ 'border-destructive': form.errors.Direccion }"
              ></textarea>
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1">
                {{ form.errors.Direccion }}
              </div>
            </div>

            <!-- Correo -->
            <div>
              <label for="correo" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Mail class="h-4 w-4 mr-1" /> Correo
              </label>
              <input
                id="correo"
                v-model="form.Correo"
                type="email"
                class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                :class="{ 'border-destructive': form.errors.Correo }"
              />
              <div v-if="form.errors.Correo" class="text-destructive text-xs mt-1">
                {{ form.errors.Correo }}
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-6 flex justify-end space-x-2">
            <Button type="button" variant="outline" @click="$emit('close')">
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing">
              <template v-if="form.processing">Creando...</template>
              <template v-else>Crear</template>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Building, User, Phone, MapPin, Mail, X, Check, Loader2, AlertCircle } from 'lucide-vue-next';

// Eventos
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg: string): void;
}>();

// Formulario
const form = useForm({
  Razon_social: '',
  Telefono: '',
  Direccion: '',
  Correo: '',
});

// Enviar
const submitForm = () => {
  form.post('/proveedores', {
    preserveScroll: true,
    onError: () => {}, // muestra errores automáticamente en form.errors
    onSuccess: () => {
      emit('created', 'Proveedor creado correctamente ✅');
      form.reset();
      emit('close');
      //refrescar la vista de proveedor
      setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 500);
    },
  });
  
};
</script>
