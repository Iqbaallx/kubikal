<template>
  <AdminLayout>
    <div class="flex-1 flex flex-col bg-gray-50">
      <!-- Fixed Header/Navbar -->
      <div class="bg-gray-800 text-white px-8 py-4 flex justify-between items-center sticky top-0 z-10 shadow-lg">
        <h1 class="text-2xl font-bold">{{ activeTab === 'menu' ? 'Kelola Menu' : 'Edit Event' }}</h1>
        <div class="flex items-center gap-4">
          <span class="text-sm">Halo</span>
          <div class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center font-bold text-sm">
            {{ initials }}
          </div>
        </div>
      </div>

      <!-- Scrollable Content Area -->
      <div class="flex-1 overflow-y-auto">
        <div class="p-8">
          <!-- Tab Content: Menu Management -->
          <div v-show="activeTab === 'menu'">
            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-6 mb-8">
              <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-4xl font-bold mb-2">{{ stats.totalMenu }}</div>
                <div class="text-gray-600 text-sm flex items-center gap-2">
                  <span>📋</span>
                  <span>Total Menu</span>
                </div>
              </div>

              <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-4xl font-bold mb-2">{{ stats.minuman }}</div>
                <div class="text-gray-600 text-sm flex items-center gap-2">
                  <span>🥤</span>
                  <span>Minuman</span>
                </div>
              </div>

              <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-4xl font-bold mb-2">{{ stats.makanan }}</div>
                <div class="text-gray-600 text-sm flex items-center gap-2">
                  <span>🍽️</span>
                  <span>Makanan</span>
                </div>
              </div>

              <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-4xl font-bold mb-2">{{ stats.favorit }}</div>
                <div class="text-gray-600 text-sm flex items-center gap-2">
                  <span>⭐</span>
                  <span>Menu Favorit</span>
                </div>
              </div>
            </div>

            <!-- Add Button -->
            <div class="flex justify-end mb-6">
              <button
                @click="showAddMenuModal = true"
                class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 font-medium shadow transition-colors"
              >
                <span>+</span>
                <span>Tambah Menu Baru</span>
              </button>
            </div>

            <!-- Menu Table -->
            <MenuTable :items="menus" />
          </div>

          <!-- Tab Content: Event Management -->
          <div v-show="activeTab === 'event'">
            <EventForm :event="event" />
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MenuTable from '@/Components/Admin/MenuTable.vue';
import EventForm from '@/Components/Admin/EventForm.vue';

const props = defineProps({
  menus: {
    type: Array,
    required: true
  },
  stats: {
    type: Object,
    required: true
  },
  event: {
    type: Object,
    required: true
  },
  currentTab: {
    type: String,
    default: 'menu'
  }
});

const page = usePage();

// Use currentTab from props (backend) or default to 'menu'
const activeTab = computed(() => props.currentTab || 'menu');

const showAddMenuModal = ref(false);

const initials = computed(() => {
  const admin = page.props.auth?.admin;
  if (!admin || !admin.name) return 'A';
  
  return admin.name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
});
</script>