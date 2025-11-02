<template>
  <div class="flex min-h-screen bg-gray-50">
    <Sidebar />
    <div class="flex-1">
      <slot />
    </div>
  </div>
</template>

<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
</script>