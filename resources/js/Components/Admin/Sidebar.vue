<template>
  <div class="w-44 bg-white border-r border-gray-200 min-h-screen flex flex-col fixed left-0 top-0 bottom-0 z-20 shadow-lg">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-100">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
          <img 
            src="/images/LOGO.png" 
            alt="Kubikal Logo" 
            class="w-6 h-6 object-contain"
          >
        </div>
        <div class="font-bold text-sm text-gray-900">
          kubikal<span class="text-indigo-600">Space</span>
        </div>
      </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
      <!-- Dashboard -->
      <button
        @click="navigateTo('dashboard')"
        :class="[
          'w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 text-sm transition-all duration-200 group relative overflow-hidden',
          isActive('dashboard') 
            ? 'text-gray-800 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
        ]"
        :style="isActive('dashboard') ? 'background-color: #D0CCCC;' : ''"
      >
        <div :class="[
          'w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
          isActive('dashboard') 
            ? 'bg-white/50' 
            : 'bg-gray-100 group-hover:bg-gray-200'
        ]">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
        </div>
        <span>Dashboard</span>
        <div v-if="isActive('dashboard')" class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 rounded-l-full" style="background-color: #383838;"></div>
      </button>

      <!-- Kelola Menu -->
      <button
        @click="navigateTo('menu')"
        :class="[
          'w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 text-sm transition-all duration-200 group relative overflow-hidden',
          isActive('menu') 
            ? 'text-gray-800 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
        ]"
        :style="isActive('menu') ? 'background-color: #D0CCCC;' : ''"
      >
        <div :class="[
          'w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
          isActive('menu') 
            ? 'bg-white/50' 
            : 'bg-gray-100 group-hover:bg-gray-200'
        ]">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <span>Kelola Menu</span>
        <div v-if="isActive('menu')" class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 rounded-l-full" style="background-color: #383838;"></div>
      </button>
      
      <!-- Kelola Event -->
      <button
        @click="navigateTo('event')"
        :class="[
          'w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 text-sm transition-all duration-200 group relative overflow-hidden',
          isActive('event') 
            ? 'text-gray-800 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
        ]"
        :style="isActive('event') ? 'background-color: #D0CCCC;' : ''"
      >
        <div :class="[
          'w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
          isActive('event') 
            ? 'bg-white/50' 
            : 'bg-gray-100 group-hover:bg-gray-200'
        ]">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <span>Kelola Event</span>
        <div v-if="isActive('event')" class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 rounded-l-full" style="background-color: #383838;"></div>
      </button>

      <!-- Kelola Gallery -->
      <button
        @click="navigateTo('gallery')"
        :class="[
          'w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 text-sm transition-all duration-200 group relative overflow-hidden',
          isActive('gallery') 
            ? 'text-gray-800 font-semibold shadow-sm' 
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
        ]"
        :style="isActive('gallery') ? 'background-color: #D0CCCC;' : ''"
      >
        <div :class="[
          'w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
          isActive('gallery') 
            ? 'bg-white/50' 
            : 'bg-gray-100 group-hover:bg-gray-200'
        ]">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <span>Kelola Gallery</span>
        <div v-if="isActive('gallery')" class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-8 rounded-l-full" style="background-color: #383838;"></div>
      </button>
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-gray-100">
      <Link
        :href="route('admin.logout')"
        method="post"
        as="button"
        class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 text-sm transition-all duration-200 group text-red-600 hover:bg-red-50 relative overflow-hidden"
      >
        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 bg-red-100 group-hover:bg-red-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </div>
        <span class="font-medium">Keluar</span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();

const currentTab = computed(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  
  if (tabParam) {
    return tabParam;
  }
  
  const currentRoute = page.url || '';
  
  if (currentRoute.includes('gallery') || currentRoute.includes('tab=gallery')) {
    return 'gallery';
  }
  
  if (currentRoute.includes('event') || currentRoute.includes('tab=event')) {
    return 'event';
  }
  
  if (currentRoute.includes('menu') || currentRoute.includes('tab=menu')) {
    return 'menu';
  }
  
  // Default ke dashboard (bukan lagi menu)
  return 'dashboard';
});

const isActive = (tab) => {
  return currentTab.value === tab;
};

const navigateTo = (tab) => {
  if (tab === 'dashboard') {
    router.get(route('admin.dashboard'), {}, {
      preserveState: false,
      preserveScroll: false,
      replace: false
    });
  } else {
    router.get(route('admin.dashboard'), { tab }, {
      preserveState: false,
      preserveScroll: false,
      replace: false
    });
  }
};
</script>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #818cf8, #a78bfa);
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #6366f1, #9333ea);
}

/* Smooth transitions */
button {
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

button:active {
  transform: scale(0.98);
}
</style>