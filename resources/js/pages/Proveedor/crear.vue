<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <!-- Toast Notification -->
    <div
      v-if="showToast"
      :class="[ 
        'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-60 flex items-center transition-all duration-300',
        toastType === 'success'
          ? 'bg-green-50 border border-green-200 text-green-800'
          : 'bg-red-50 border border-red-200 text-red-800'
      ]"
    >
      <CheckCircle v-if="toastType === 'success'" class="h-5 w-5 mr-2" />
      <AlertCircle v-else class="h-5 w-5 mr-2" />
      <span>{{ toastMessage }}</span>
      <button @click="showToast = false" class="ml-4 text-gray-500 hover:text-gray-700">
        <X class="h-4 w-4" />
      </button>
    </div>

    <!-- Modal -->
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <!-- Título -->
        <div class="flex items-center mb-4">
          <Building class="h-5 w-5 mr-2 text-primary" />
          <h2 class="text-xl font-semibold text-foreground">Crear Nuevo Proveedor</h2>
        </div>

        <!-- Formulario -->
        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Razón social -->
            <div>
              <label for="razon_social" class="flex items-center text-sm font-medium text-foreground mb-2">
                <User class="h-4 w-4 mr-1" /> Razón Social *
              </label>
              <input
                id="razon_social"
                v-model="form.Razon_social"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                :class="{ 'border-destructive': form.errors.Razon_social }"
              />
              <div v-if="form.errors.Razon_social" class="text-destructive text-xs mt-1">
                {{ form.errors.Razon_social }}
              </div>
            </div>

            <!-- Teléfono -->
            <div>
              <label for="telefono" class="flex items-center text-sm font-medium text-foreground mb-2">
                <Phone class="h-4 w-4 mr-1" /> Teléfono
              </label>
              <input
                id="telefono"
                v-model="form.Telefono"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent pl-9 pr-3 py-1 text-sm"
                :class="{ 'border-destructive': form.errors.Telefono }"
              />
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
            <Button type="button" variant="outline" @click="$emit('close')" class="px-4">
              Cancelar
            </Button>
            <Button type="submit" :disabled="form.processing" class="px-4">
              <span v-if="form.processing">Creando...</span>
              <span v-else>Crear</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Building, User, Phone, MapPin, Mail, CheckCircle, AlertCircle, X } from 'lucide-vue-next';

// Emits
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'created', msg:string, type:any): void;
}>();

// Formulario
const form = useForm({
  Razon_social: '',
  Telefono: '',
  Direccion: '',
  Correo: '',
});

// Toast
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

const showNotification = (message: string, type: 'success' | 'error' = 'success') => {
  toastMessage.value = message;
  toastType.value = type;
  showToast.value = true;
  setTimeout(() => {
    showToast.value = false;
  }, 3000);
};

// Enviar formulario
const submitForm = () => {
  form.post('/proveedores', {
    preserveScroll: true,
    onSuccess: () => {
      emit('created', 'Proveedor creado exitosamente!', 'success');
      emit('close');
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    },
    onError: () => {
      showNotification('Error al crear el proveedor ❌', 'error');
    },
  });
};
</script>
