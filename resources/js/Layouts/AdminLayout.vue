<template>
  <div class="min-h-screen" style="background: linear-gradient(0deg, #F5F5F4, #F5F5F4), #FFFFFF;">
    <!-- Hamburger Button (Mobile Only) -->
    <button
      @click="toggleMobileMenu"
      class="md:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg hover:bg-gray-50 transition-colors"
    >
      <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Sidebar - Fixed -->
    <Sidebar :isMobileMenuOpen="isMobileMenuOpen" @closeMobile="closeMobileMenu" />
    
    <!-- Main Content Area -->
    <slot />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};
</script>