<template>
  <AdminLayout>
    <div class="p-8">
      <!-- Tabs Navigation -->
      <div class="flex gap-2 mb-6">
        <button
          @click="currentTab = 'menu'"
          :class="[
            'px-6 py-3 rounded-t-lg font-semibold transition-colors',
            currentTab === 'menu' 
              ? 'bg-gray-800 text-white' 
              : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
          ]"
        >
          📋 Kelola Menu
        </button>
        <button
          @click="currentTab = 'event'"
          :class="[
            'px-6 py-3 rounded-t-lg font-semibold transition-colors',
            currentTab === 'event' 
              ? 'bg-gray-800 text-white' 
              : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
          ]"
        >
          📅 Kelola Event
        </button>
      </div>

      <!-- Tab Content: Menu Management -->
      <div v-show="currentTab === 'menu'">
        <Header title="Kelola Menu" />

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-4 my-6">
          <StatsCard 
            :value="stats.totalMenu" 
            label="Total Menu" 
            icon="📋" 
          />
          <StatsCard 
            :value="stats.minuman" 
            label="Minuman" 
            icon="🥤" 
          />
          <StatsCard 
            :value="stats.makanan" 
            label="Makanan" 
            icon="🍽️" 
          />
          <StatsCard 
            :value="stats.favorit" 
            label="Menu Favorit" 
            icon="⭐" 
          />
        </div>

        <!-- Add Button -->
        <div class="flex justify-end mb-4">
          <button
            @click="showAddMenuModal = true"
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded flex items-center gap-2"
          >
            <span>➕</span>
            <span>Tambah Menu Baru</span>
          </button>
        </div>

        <!-- Menu Table -->
        <MenuTable 
          :items="menus" 
        />
      </div>

      <!-- Tab Content: Event Management -->
      <div v-show="currentTab === 'event'">
        <Header title="Edit Event" />
        <EventForm :event="event" />
      </div>
    </div>

    <!-- Modal Tambah Menu (Optional) -->
    <Modal :show="showAddMenuModal" @close="showAddMenuModal = false">
      <div class="p-6">
        <h3 class="text-xl font-bold mb-4">Tambah Menu Baru</h3>
        <!-- Form tambah menu bisa ditambahkan di sini -->
        <p class="text-gray-600">Form tambah menu...</p>
      </div>
    </Modal>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Header from '@/Components/Admin/Header.vue';
import StatsCard from '@/Components/Admin/StatsCard.vue';
import MenuTable from '@/Components/Admin/MenuTable.vue';
import EventForm from '@/Components/Admin/EventForm.vue';

// Props dari backend
defineProps({
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
  }
});

// State untuk tab aktif
const currentTab = ref('menu'); // 'menu' atau 'event'
const showAddMenuModal = ref(false);
</script>