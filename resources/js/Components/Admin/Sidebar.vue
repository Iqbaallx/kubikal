<template>
  <div class="w-44 bg-gray-100 min-h-screen p-4 flex flex-col fixed left-0 top-0 bottom-0">
    <!-- Logo -->
    <div class="flex items-center gap-3 mb-10">
      <div class="w-9 h-9 bg-black text-white flex items-center justify-center font-bold text-lg rounded">
        K
      </div>
      <div class="font-semibold text-sm">Kubikal Space</div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="space-y-1 flex-1">
      <button
        @click="navigateTo('menu')"
        :class="[
          'w-full text-left px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm transition-colors',
          isActive('menu') ? 'bg-gray-300 font-medium' : 'hover:bg-gray-200 text-gray-700'
        ]"
      >
        <span class="text-base">📋</span>
        <span>Kelola Menu</span>
      </button>
      
      <button
        @click="navigateTo('event')"
        :class="[
          'w-full text-left px-4 py-2.5 rounded-lg flex items-center gap-3 text-sm transition-colors',
          isActive('event') ? 'bg-gray-300 font-medium' : 'hover:bg-gray-200 text-gray-700'
        ]"
      >
        <span class="text-base">📅</span>
        <span>Kelola Event</span>
      </button>
    </nav>

    <!-- Logout Button -->
    <div class="mt-auto pt-4 border-t border-gray-300">
      <Link
        :href="route('admin.logout')"
        method="post"
        as="button"
        class="text-gray-600 hover:text-gray-900 text-sm flex items-center gap-2 w-full transition-colors"
      >
        <span>←</span>
        <span>Keluar</span>
      </Link>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();

const currentTab = computed(() => {
  const currentRoute = page.props.ziggy?.location || '';
  if (currentRoute.includes('event')) {
    return 'event';
  }
  return 'menu';
});

const isActive = (tab) => {
  return currentTab.value === tab;
};

const navigateTo = (tab) => {
  // Navigate to dashboard with tab parameter
  router.get(route('admin.dashboard'), { tab }, {
    preserveState: true,
    preserveScroll: false
  });
};
</script>