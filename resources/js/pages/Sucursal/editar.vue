<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-background rounded-lg border border-border shadow-lg w-full max-w-md">
      <div class="p-6">
        <h2 class="text-xl font-semibold text-foreground mb-4">
          Editar Sucursal
        </h2>

        <form @submit.prevent="submitForm">
          <div class="space-y-4">
            <!-- Nombre de la sucursal -->
            <div>
              <label for="Nombre_Sucursal" class="block text-sm font-medium text-foreground mb-2">
                Nombre de Sucursal *
              </label>
              <input
                id="Nombre_Sucursal"
                v-model="form.Nombre_Sucursal"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                required
                :class="{ 'border-destructive': form.errors.Nombre_Sucursal }"
                placeholder="Ingrese el nombre de la sucursal"
              />
              <div v-if="form.errors.Nombre_Sucursal" class="text-destructive text-xs mt-1">
                {{ form.errors.Nombre_Sucursal }}
              </div>
            </div>

            <!-- Dirección -->
            <div>
              <label for="Direccion" class="block text-sm font-medium text-foreground mb-2">
                Dirección *
              </label>
              <input
                id="Direccion"
                v-model="form.Direccion"
                type="text"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                required
                :class="{ 'border-destructive': form.errors.Direccion }"
                placeholder="Ingrese la dirección de la sucursal"
              />
              <div v-if="form.errors.Direccion" class="text-destructive text-xs mt-1">
                {{ form.errors.Direccion }}
              </div>
            </div>

            <!-- Gerente -->
            <div>
              <label for="Gerente" class="block text-sm font-medium text-foreground mb-2">
                Gerente
              </label>
              <select
                id="Gerente"
                v-model="form.Gerente"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                :class="{ 'border-destructive': form.errors.Gerente }"
              >
                <option value="">Seleccione Gerente</option>
                <option value="Marlon">Marlon</option>
                <option value="Pablo">Pablo</option>
              </select>
              <div v-if="form.errors.Gerente" class="text-destructive text-xs mt-1">
                {{ form.errors.Gerente }}
              </div>
            </div>
          </div>

          <!-- Botones -->
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
              <span v-if="form.processing">Guardando...</span>
              <span v-else>Guardar Cambios</span>
            </Button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import type { Sucursal } from '@/types'

// Props que recibe la sucursal a editar
const props = defineProps<{ sucursal: Sucursal }>()

// Eventos emitidos
const emit = defineEmits<{
  (e: 'close'): void
  (e: 'updated'): void
}>()

// Formulario con datos precargados desde la sucursal seleccionada
const form = useForm({
  Nombre_Sucursal: props.sucursal.Nombre_Sucursal || '',
  Direccion: props.sucursal.Direccion || '',
  Gerente: props.sucursal.Gerente || '',
})

// Función para actualizar en el backend
const submitForm = () => {
  form.put(`/sucursales/${props.sucursal.Idsucursal}`, {
    preserveScroll: true,
    onSuccess: () => {
      emit('updated')
      emit('close')
    },
  })
}
</script>
