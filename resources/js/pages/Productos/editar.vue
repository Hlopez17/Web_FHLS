<template>
  <!-- Fondo oscuro y modal centrado -->
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <!-- Título del modal con icono -->
        <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">
            Editar Producto
          </h2>
        </div>
        
        <!-- Formulario de edición -->
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Campo Razón Social -->
            <div>
              <label for="razon_social" class="flex items-center text-sm font-medium text-foreground mb-2">
                <User class="h-4 w-4 mr-1" />
                Razón Social *
              </label>
              <div class="relative">
                <input
                  id="razon_social"
                  v-model="form.Razon_social"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  required
                  :class="{ 'border-destructive': form.errors.Razon_social }"
                />
                <User class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <!-- Mensaje de error para Razón Social -->
              <div v-if="form.errors.Razon_social" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Razon_social }}
              </div>
            </div>

            <!-- Campo Teléfono -->
            <div>
              <label for="telefono" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Phone class="h-4 w-4 mr-1" />
                Teléfono
              </label>
              <div class="relative">
                <input
                  id="telefono"
                  v-model="form.Telefono"
                  type="text"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Telefono }"
                />
                <Phone class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <!-- Mensaje de error para Teléfono -->
              <div v-if="form.errors.Telefono" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Telefono }}
              </div>
            </div>

            <!-- Campo Dirección -->
            <div>
              <label for="direccion" class="flex items-center text-sm font-medium text-foreground mb-2">
                <MapPin class="h-4 w-4 mr-1" />
                Dirección
              </label>
              <div class="relative">
                <textarea
                  id="direccion"
                  v-model="form.Direccion"
                  rows="3"
                  class="flex min-h-[60px] w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Direccion }"
                ></textarea>
                <MapPin class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
              </div>
              <!-- Mensaje de error para Dirección -->
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Direccion }}
              </div>
            </div>

            <!-- Campo Correo -->
            <div>
              <label for="correo" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Mail class="h-4 w-4 mr-1" />
                Correo Electrónico
              </label>
              <div class="relative">
                <input
                  id="correo"
                  v-model="form.Correo"
                  type="email"
                  class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                  :class="{ 'border-destructive': form.errors.Correo }"
                />
                <Mail class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              </div>
              <!-- Mensaje de error para Correo -->
              <div v-if="form.errors.Correo" class="text-destructive text-xs mt-1 flex items-center">
                <AlertCircle class="h-3 w-3 mr-1" />
                {{ form.errors.Correo }}
              </div>
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="mt-6 flex justify-end space-x-2">
            <!-- Botón cancelar, cierra el modal -->
            <Button
              type="button"
              variant="outline"
              @click="$emit('close')"
              class="px-4 flex items-center"
            >
              <X class="h-4 w-4 mr-1" />
              Cancelar
            </Button>
            <!-- Botón guardar, envía el formulario -->
            <Button
              type="submit"
              :disabled="form.processing"
              class="px-4 flex items-center"
            >
              <template v-if="form.processing">
                <Loader2 class="h-4 w-4 mr-1 animate-spin" />
                Guardando...
              </template>
              <template v-else>
                <Save class="h-4 w-4 mr-1" />
                Guardar Cambios
              </template>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Building, User, Phone, MapPin, Mail, X, Save, Loader2, AlertCircle } from 'lucide-vue-next';
import type { Proveedor } from '@/types';

// Props: se recibe el proveedor actual que se va a editar
const props = defineProps<{
  proveedor: Proveedor;
}>();

// Emits: eventos personalizados que el componente puede emitir
const emit = defineEmits<{
  (e: 'close'): void;    // Para cerrar el modal
  (e: 'updated'): void;  // Para notificar que el proveedor fue actualizado
}>();

// Formulario con datos iniciales del proveedor
const form = useForm({
  Razon_social: props.proveedor.Razon_social,
  Telefono: props.proveedor.Telefono || '',
  Direccion: props.proveedor.Direccion,
  Correo: props.proveedor.Correo,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.put(`/proveedores/${props.proveedor.id}`, { // PUT para actualizar proveedor
    preserveScroll: true, // Mantiene el scroll en su posición
    onSuccess: () => {
      emit('updated'); // Se emite evento de actualización
      emit('close');   // Se cierra el modal
    },
  });
};
</script>