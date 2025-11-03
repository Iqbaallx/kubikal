<template>
  <div class="flex min-h-screen bg-gray-50">
    <!-- Fixed Sidebar -->
    <Sidebar />
    
    <!-- Main Content with margin for sidebar -->
    <div class="flex-1 ml-44">
      <slot />
    </div>
  </div>
</template>

<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
</script>