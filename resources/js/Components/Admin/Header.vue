<template>
  <div class="bg-gray-800 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
    <h1 class="text-2xl font-bold">{{ title }}</h1>
    <div class="flex items-center gap-4">
      <span>Halo</span>
      <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center font-bold">
        {{ initials }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

defineProps({
  title: {
    type: String,
    required: true
  }
});

const page = usePage();

// Get initials from admin name
const initials = computed(() => {
  const admin = page.props.auth?.admin;
  if (!admin || !admin.name) return 'A';
  
  return admin.name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
});
</script>