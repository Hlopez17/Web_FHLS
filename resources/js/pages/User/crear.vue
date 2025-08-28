
<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md max-h-[90vh] overflow-y-auto">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Crear Nuevo Usuario
        </h2>
        
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <div>
              <label for="name" class="block text-sm font-medium text-foreground mb-2">
                Nombre *
              </label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.name }"
              />
              <div v-if="form.errors.name" class="text-destructive text-xs mt-1">
                {{ form.errors.name }}
              </div>
            </div>

            <div>
              <label for="apellido" class="block text-sm font-medium text-foreground mb-2">
                Apellido
              </label>
              <input
                id="apellido"
                v-model="form.Apellido"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Apellido }"
              />
              <div v-if="form.errors.Apellido" class="text-destructive text-xs mt-1">
                {{ form.errors.Apellido }}
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-foreground mb-2">
                Email *
              </label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.email }"
              />
              <div v-if="form.errors.email" class="text-destructive text-xs mt-1">
                {{ form.errors.email }}
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-foreground mb-2">
                Contraseña *
              </label>
              <input
                id="password"
                v-model="form.password"
                type="password"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                required
                :class="{ 'border-destructive': form.errors.password }"
              />
              <div v-if="form.errors.password" class="text-destructive text-xs mt-1">
                {{ form.errors.password }}
              </div>
            </div>

            <div>
              <label for="telefono" class="block text-sm font-medium text-foreground mb-2">
                Teléfono
              </label>
              <input
                id="telefono"
                v-model="form.Telefono"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Telefono }"
              />
              <div v-if="form.errors.Telefono" class="text-destructive text-xs mt-1">
                {{ form.errors.Telefono }}
              </div>
            </div>

            <div>
              <label for="Idrol" class="block text-sm font-medium text-foreground mb-2">
                Rol
              </label>
              <select
                id="Idrol"
                v-model="form.Idrol"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Idrol }"
              >
                <option value="">Seleccionar rol</option>
                <option v-for="role in roles" :key="role.Idrol" :value="role.Idrol">
                  {{ role.nombre }}
                </option>
              </select>
              <div v-if="form.errors.Idrol" class="text-destructive text-xs mt-1">
                {{ form.errors.Idrol }}
              </div>
            </div>


            <div>
              <label for="Estado" class="block text-sm font-medium text-foreground mb-2">
                Estado
              </label>
              <select
                id="Estado"
                v-model="form.Estado"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Estado }"
              >
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
              <div v-if="form.errors.Estado" class="text-destructive text-xs mt-1">
                {{ form.errors.Estado }}
              </div>
            </div>

            <div>
              <label for="Comision" class="block text-sm font-medium text-foreground mb-2">
                Comisión (%)
              </label>
              <input
                id="Comision"
                v-model="form.Comision"
                type="number"
                step="0.01"
                min="0"
                max="100"
                class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-background file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                :class="{ 'border-destructive': form.errors.Comision }"
              />
              <div v-if="form.errors.Comision" class="text-destructive text-xs mt-1">
                {{ form.errors.Comision }}
              </div>
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
              <span v-else>Crear Usuario</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

// Props
const props = defineProps<{
  roles: any[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string): void;
}>();

// Formulario con datos iniciales vacíos
const form = useForm({
  name: '',
  Apellido: '',
  email: '',
  password: '',
  Telefono: '',
  Idrol: null,
  Estado: 'Activo',
  Comision: 0,
});

// Función para enviar el formulario al backend
const submitForm = () => {
  form.post('/usuarios', {
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Usuario creado correctamente ✅');
      emit('close');

       setTimeout(() => {
        router.visit(window.location.href, { replace: true });
      }, 1000);
    },
  });
};
</script>