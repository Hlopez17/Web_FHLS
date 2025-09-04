<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import { computed, ref, watch } from 'vue';

interface Props {
  user: User;
  showEmail?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  showEmail: false,
});

const { getInitials } = useInitials();

// Timestamp para invalidar cache
const imageTimestamp = ref(Date.now());

// Watcher para cambios en la URL del perfil
watch(
  () => props.user.profile_image_url,
  (newUrl, oldUrl) => {
    if (newUrl && newUrl !== oldUrl) {
      imageTimestamp.value = Date.now();
    }
  }
);

// URL de la imagen con query param
const imageUrlWithTimestamp = computed(() => {
  if (!props.user.profile_image_url) return null;
  return `${props.user.profile_image_url}?t=${imageTimestamp.value}`;
});

// Controlar si hubo error cargando la imagen
const imageError = ref(false);

const handleImageError = () => {
  imageError.value = true;
};
</script>

<template>
  <div class="flex items-center gap-3">
    <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
      <AvatarImage
        v-if="imageUrlWithTimestamp && !imageError"
        :key="imageUrlWithTimestamp" 
        :src="imageUrlWithTimestamp"
        :alt="user.name"
        class="object-cover"
        @error="handleImageError"
      />
      <AvatarFallback class="rounded-lg text-black dark:text-white">
        {{ getInitials(user.name) }}
      </AvatarFallback>
    </Avatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
      <span class="truncate font-medium">{{ user.name }}</span>
      <span v-if="showEmail" class="truncate text-xs text-muted-foreground">
        {{ user.email }}
      </span>
    </div>
  </div>
</template>
