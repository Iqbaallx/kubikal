<template>
  <div class="min-h-screen" style="background: linear-gradient(0deg, #F5F5F4, #F5F5F4), #FFFFFF;">
    <!-- Sidebar - Fixed -->
    <Sidebar />
    
    <!-- Main Content Area -->
    <slot />
  </div>
</template>

<script setup>
import Sidebar from '@/Components/Admin/Sidebar.vue';
</script>