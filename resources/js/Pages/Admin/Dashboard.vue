<template>
  <AdminLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
      <div class="ml-44">
        <!-- Header -->
        <DashboardHeader :activeTab="activeTab" :initials="initials" />

        <!-- Main Content -->
        <div class="p-8">
          <div class="max-w-[1600px] mx-auto space-y-6">
            
            <!-- Dashboard Overview -->
            <DashboardOverview 
              v-show="activeTab === 'dashboard'" 
              :stats="stats"
              :recentMenus="menus.slice(0, 3)"
              :recentEvents="events.slice(0, 3)"
              :galleryCount="galleries.main.length + galleries.standard.length"
            />

            <!-- Menu Management -->
            <KelolaMenu 
              v-show="activeTab === 'menu'" 
              :menus="menus" 
              :stats="stats" 
            />

            <!-- Event Management -->
            <KelolaEvent 
              v-show="activeTab === 'event'" 
              :events="events" 
            />

            <!-- Gallery Management -->
            <KelolaGallery 
              v-show="activeTab === 'gallery'" 
              :galleries="galleries" 
            />

          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DashboardHeader from '@/Components/Admin/DashboardHeader.vue';
import DashboardOverview from '@/Components/Admin/DashboardOverview.vue';
import KelolaMenu from '@/Components/Admin/KelolaMenu.vue';
import KelolaEvent from '@/Components/Admin/KelolaEvent.vue';
import KelolaGallery from '@/Components/Admin/KelolaGallery.vue';

const props = defineProps({
  menus: { type: Array, default: () => [] },
  stats: { type: Object, default: () => ({ totalMenu: 0, minuman: 0, makanan: 0, favorit: 0 }) },
  events: { type: Array, default: () => [] },

  // --------------- FIX DI SINI ---------------
  galleries: { 
    type: Object,
    default: () => ({
      main: [],
      small_1: null,
      small_2: null,
      standard: []
    })
  },
  // --------------------------------------------

  currentTab: { type: String, default: 'dashboard' }
});

const page = usePage();

// GET INITIAL TAB FROM URL
const getInitialTab = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  return tabParam || 'dashboard';
};

const activeTab = ref(getInitialTab());

// Update when URL changes
watch(() => page.url, () => {
  activeTab.value = getInitialTab();
});

const initials = computed(() => {
  const admin = page.props.auth?.admin;
  if (!admin || !admin.name) return 'A';
  return admin.name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2);
});
</script>
