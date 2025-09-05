<script setup lang="ts">
// Importaciones necesarias desde Inertia y componentes locales
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Camera, Upload, Loader2 } from 'lucide-vue-next';

// Props que vienen desde el servidor o padre
interface Props {
    mustVerifyEmail: boolean; // Indica si el usuario debe verificar su correo
    status?: string;          // Estado de verificación o actualización
}

defineProps<Props>();

// Items para el breadcrumb (navegación jerárquica)
const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

// Obtenemos la página actual con los datos del usuario autenticado
const page = usePage();
const user = page.props.auth.user as User;

// Definimos el formulario con datos iniciales del usuario
const form = useForm({
    name: user.name,
    email: user.email,
});

// Función que se ejecuta al enviar el formulario principal
const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true, // Mantener el scroll después de actualizar
    });
};

// --- Manejo de imagen de perfil ---
const imageForm = useForm({
    profile_image: null as File | null,
});

const imagePreview = ref<string | null>(user.profile_image_url ?? null);
const fileInput = ref<HTMLInputElement | null>(null);

// Observar cambios en el usuario para actualizar la imagen
watch(() => page.props.auth.user, (newUser) => {
    if (newUser) {
        imagePreview.value = (newUser as User).profile_image_url;
    }
});

// Evento al seleccionar archivo
const handleFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        const file = target.files[0];
        imageForm.profile_image = file;
        
        // Crear preview local usando FileReader para mejor compatibilidad
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

// Abrir el selector de archivos al hacer clic en la imagen
const triggerFileInput = () => {
    fileInput.value?.click();
};

// Enviar imagen al servidor
const submitImage = () => {
    if (!imageForm.profile_image) return;

    // Usar transform para enviar como FormData
    imageForm.transform((data) => {
        const formData = new FormData();
        if (data.profile_image) {
            formData.append('profile_image', data.profile_image);
        }
        return formData;
    }).post(route('profile.image.update'), {
        preserveScroll: true,
        onSuccess: () => {
            imageForm.reset();
            // La imagen se actualizará automáticamente por el watch
        },
        onError: (errors) => {
            console.error('Error uploading image:', errors);
        }
    });
};
</script>

<template>
    <!-- Layout principal con migas de pan -->
    <AppLayout :breadcrumbs="breadcrumbItems">
        <!-- Título de la pestaña -->
        <Head title="Profile settings" />

        <!-- Layout de configuración -->
        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <!-- Encabezado pequeño -->
                <HeadingSmall title="Profile information" description="Update your name and email address" />

                <!-- Formulario para actualizar datos -->
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Campo: Nombre -->
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autocomplete="name"
                            placeholder="Full name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Campo: Correo -->
                    <div class="grid gap-2">
                        <Label for="email">Email address</Label>
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            placeholder="Email address"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Mensaje y link de verificación de correo -->
                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                Click here to resend the verification email.
                            </Link>
                        </p>

                        <!-- Confirmación de envío del correo de verificación -->
                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <!-- Botón de guardar y mensaje de éxito -->
                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <!-- Subida de imagen de perfil - DISEÑO MEJORADO -->
            <div class="mt-10 flex flex-col space-y-6">
                <HeadingSmall title="Profile Picture" description="Upload a professional photo to personalize your account" />

                <form @submit.prevent="submitImage" class="space-y-6">
                    <div class="flex flex-col items-center space-y-6 p-6 bg-muted/30 rounded-lg border border-border">
                        <!-- Vista previa con overlay interactivo -->
                        <div 
                            class="relative w-40 h-40 rounded-full overflow-hidden border-2 border-dashed border-muted-foreground/30 cursor-pointer group"
                            @click="triggerFileInput"
                        >
                            <img 
                                v-if="imagePreview" 
                                :src="imagePreview" 
                                alt="Profile preview" 
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" 
                            />
                            <div v-else class="w-full h-full flex items-center justify-center bg-muted">
                                <Camera class="w-12 h-12 text-muted-foreground/50" />
                            </div>
                            
                            <!-- Overlay al hover -->
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <Camera class="w-8 h-8 text-white" />
                                <span class="sr-only">Change photo</span>
                            </div>
                            
                            <!-- Badge de nueva imagen -->
                            <div 
                                v-if="imageForm.profile_image" 
                                class="absolute top-2 right-2 bg-primary text-primary-foreground text-xs px-2 py-1 rounded-full"
                            >
                                New
                            </div>
                        </div>

                        <!-- Input de archivo oculto -->
                        <input
                            ref="fileInput"
                            id="profile_image"
                            type="file"
                            accept="image/*"
                            @change="handleFileChange"
                            class="hidden"
                        />

                        <!-- Información y botones -->
                        <div class="text-center space-y-3">
                            <div class="space-y-2">
                                <Label for="profile_image" class="text-base font-medium cursor-pointer">
                                    <Upload class="w-4 h-4 inline mr-2" />
                                    Choose a photo
                                </Label>
                                
                                <p class="text-sm text-muted-foreground max-w-md">
                                    Recommended: Square image, at least 200x200 pixels. 
                                    <br>JPG, PNG, GIF or WEBP. Max 2MB.
                                </p>
                                
                                <InputError class="mt-2" :message="imageForm.errors.profile_image" />
                                
                                <p v-if="imageForm.profile_image" class="text-sm text-green-600 font-medium">
                                    ✓ Image selected: {{ imageForm.profile_image.name }}
                                </p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex gap-3 justify-center pt-2">
                                <Button 
                                    type="button"
                                    variant="outline" 
                                    @click="triggerFileInput"
                                    class="gap-2"
                                >
                                    <Camera class="w-4 h-4" />
                                    Choose Different
                                </Button>
                                
                                <Button 
                                    type="submit" 
                                    :disabled="imageForm.processing || !imageForm.profile_image"
                                    class="gap-2"
                                    :class="{ 'opacity-50 cursor-not-allowed': !imageForm.profile_image }"
                                >
                                    <Loader2 v-if="imageForm.processing" class="w-4 h-4 animate-spin" />
                                    <Upload v-else class="w-4 h-4" />
                                    {{ imageForm.processing ? 'Uploading...' : 'Save Changes' }}
                                </Button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Componente para eliminar cuenta de usuario -->
            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>

<style scoped>
/* Efectos de transición mejorados */
.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

/* Mejoras para el input de archivo personalizado */
.file-input-label {
    transition: all 0.2s ease-in-out;
}

.file-input-label:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Animación sutil para la imagen */
img {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Mejora para el estado disabled */
button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>