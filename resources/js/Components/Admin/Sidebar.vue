<template>
  <div class="w-44 bg-white border-r border-gray-200 min-h-screen p-4 flex flex-col fixed left-0 top-0 bottom-0 z-20 shadow-sm">
    <!-- Logo Section -->
    <div class="flex items-center gap-3 mb-10 px-2">
      <div class="w-10 h-10 bg-black text-white flex items-center justify-center font-bold text-xl rounded">
        K
      </div>
      <div class="font-semibold text-sm text-gray-900">
        kubikal Space
      </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="space-y-1 flex-1">
      <button
        @click="navigateTo('menu')"
        :class="[
          'w-full text-left px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm transition-all duration-200 group',
          isActive('menu') 
            ? 'bg-gray-300 text-gray-900 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900'
        ]"
      >
        <span 
          :class="[
            'text-base transition-all duration-200',
            isActive('menu') ? 'scale-110' : 'group-hover:scale-110'
          ]"
        >
          📋
        </span>
        <span>Kelola Menu</span>
      </button>
      
      <button
        @click="navigateTo('event')"
        :class="[
          'w-full text-left px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm transition-all duration-200 group',
          isActive('event') 
            ? 'bg-gray-300 text-gray-900 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-200 hover:text-gray-900'
        ]"
      >
        <span 
          :class="[
            'text-base transition-all duration-200',
            isActive('event') ? 'scale-110' : 'group-hover:scale-110'
          ]"
        >
          📅
        </span>
        <span>Kelola Event</span>
      </button>
    </nav>

    <!-- Logout Button -->
    <div class="mt-auto pt-4 border-t border-gray-200">
      <Link
        :href="route('admin.logout')"
        method="post"
        as="button"
        class="text-gray-600 hover:text-red-600 hover:bg-red-50 text-sm flex items-center gap-3 w-full px-4 py-2.5 rounded-lg transition-all duration-200 group"
      >
        <span class="text-base group-hover:scale-110 transition-transform">🚪</span>
        <span class="font-medium">Keluar</span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();

// Ambil currentTab dari props atau URL
const currentTab = computed(() => {
  // Cek dari query parameter
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  
  if (tabParam) {
    return tabParam;
  }
  
  // Cek dari route name
  const currentRoute = page.url || '';
  if (currentRoute.includes('event') || currentRoute.includes('tab=event')) {
    return 'event';
  }
  
  // Default ke menu
  return 'menu';
});

const isActive = (tab) => {
  return currentTab.value === tab;
};

const navigateTo = (tab) => {
  router.get(route('admin.dashboard'), { tab }, {
    preserveState: false,
    preserveScroll: false,
    replace: false
  });
};
</script>