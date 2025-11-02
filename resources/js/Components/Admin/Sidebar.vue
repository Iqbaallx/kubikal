<template>
  <div class="w-48 bg-gray-100 min-h-screen p-4 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center gap-2 mb-8">
      <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-bold text-xl rounded">
        K
      </div>
      <div class="font-bold text-sm">Kubikal Space</div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="space-y-2 flex-1">
      <Link
        :href="route('admin.menu.index')"
        :class="[
          'w-full text-left px-4 py-2 rounded flex items-center gap-2',
          isActive('admin.menu.*') ? 'bg-gray-300' : 'hover:bg-gray-200'
        ]"
      >
        <span>📋</span>
        <span>Kelola Menu</span>
      </Link>
      
      <Link
        :href="route('admin.event.index')"
        :class="[
          'w-full text-left px-4 py-2 rounded flex items-center gap-2',
          isActive('admin.event.*') ? 'bg-gray-300' : 'hover:bg-gray-200'
        ]"
      >
        <span>📅</span>
        <span>Kelola Event</span>
      </Link>
    </nav>

    <!-- Logout Button -->
    <div class="mt-auto">
      <Link
        :href="route('logout')"
        method="post"
        as="button"
        class="text-gray-600 hover:text-gray-800 text-sm flex items-center gap-2 w-full"
      >
        <span>←</span>
        <span>Keluar</span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

// Helper function to check active route
const isActive = (routeName) => {
  return route().current(routeName);
};
</script>