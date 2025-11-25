<template>
  <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
    <div class="px-8 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <div class="h-10 w-1 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full"></div>
          <h1 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
            {{ getTitle() }}
          </h1>
        </div>
        <div class="flex items-center gap-4">
          <span class="text-sm text-gray-600 font-medium">Halo, Admin</span>
          <div class="relative">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center font-bold text-white text-sm shadow-lg shadow-indigo-200 ring-2 ring-white">
              {{ initials }}
            </div>
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  activeTab: { type: String, required: true },
  initials: { type: String, required: true }
});

const getTitle = () => {
  const titles = {
    dashboard: 'Dashboard',
    menu: 'Kelola Menu',
    event: 'Kelola Event',
    gallery: 'Kelola Gallery'
  };
  return titles[props.activeTab] || 'Dashboard';
};
</script>