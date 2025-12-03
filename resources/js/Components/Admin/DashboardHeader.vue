<template>
  <div class="sticky top-0 z-40 text-white border-b border-gray-200/50 shadow-sm" style="background-color: #383838;">
    <div class="px-8 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
          <!-- Page Title Only -->
          <h1 class="text-2xl font-bold text-white">
            {{ getTitle() }}
          </h1>
        </div>
        
        <div class="flex items-center gap-4">
          <span class="text-sm text-gray-200 font-medium">Halo</span>
          <div class="relative">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shadow-lg" style="background-color: #D0CCCC; color: #383838;">
              {{ initials }}
            </div>
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-700"></div>
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