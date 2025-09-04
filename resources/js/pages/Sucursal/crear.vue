<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nueva Sucursal
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="Nombre_Sucursal" class="block text-sm font-medium text-foreground mb-2">
                Nombre de Sucursal *
              </label>
              <input
                id="Nombre_Sucursal"
                v-model="form.Nombre_Sucursal"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Nombre_Sucursal }"
                placeholder="Ingrese el nombre de la Sucursal"
              />
              <div v-if="form.errors.Nombre_Sucursal" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_Sucursal }}
              </div>
            </div>

            <div>
              <label for="Direccion" class="block text-sm font-medium text-foreground mb-2">
                Direccion de Sucursal *
              </label>
              <input
                id="Direccion"
                v-model="form.Direccion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"

                :class="{ 'border-destructive': form.errors.Direccion }"
                placeholder="Ingrese la dirección de la Sucursal"
              />
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1">
                {{ form.errors.Direccion }}
              </div>
            </div>

            <div>
              <label for="Gerente" class="block text-sm font-medium text-foreground mb-2">
                Gerente de Sucursal
              </label>
                <select
                id="Gerente"
                v-model="form.Gerente"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Gerente }"
                >
              <option value="">Seleccione Gerente</option><!--Deben de cargar los nombres de los Usuarios-->
              <option value="Activo">Marlon</option>
              <option value="Inactivo">Pablo</option>
              </select>

              <div v-if="form.errors.Gerente" class="text-destructive text-xs mt-1">
                {{ form.errors.Gerente }}
              </div>
            </div>

          <div class="mt-6 flex justify-end space-x-2">
            <Button
              type="button"
              variant="outline"
              @click="$emit('close')"
              class="px-4"
            >
              Cancelar
            </Button>
            <Button
              type="submit"
              :disabled="form.processing"
              class="px-4"
            >
              <span v-if="form.processing">Creando...</span>
              <span v-else>Crear Sucursal</span>
            </Button>
          </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string, type:any): void;
}>();

// Formulario con datos iniciales vacíos
const form = useForm({
  Nombre_Sucursal: '',
  Direccion: '',
  Gerente: '',
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.post('/Sucursal', {
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Sucursal creada correctamente', 'success');
      emit('close');

      setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 1000);
    },
  });
};
</script>