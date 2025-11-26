<template>
  <div class="space-y-6">
    <!-- Stats Cards - Outside Container -->
    <MenuStats :stats="stats" />

    <!-- Main Container Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <!-- Action Button -->
      <div class="flex justify-end mb-6">
        <button
          @click="openAddModal"
          class="group flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-300 font-medium"
        >
          <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          <span>Tambah Menu Baru</span>
        </button>
      </div>

      <!-- Menu Table -->
      <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <MenuTable :items="menus" @edit="openEditModal" @show-detail="handleShowDetail" />
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <MenuFormModal 
      :show="showModal" 
      :isEditing="isEditing"
      :formData="selectedMenu"
      @close="closeModal"
    />

    <!-- Detail Modal -->
    <MenuDetailModal 
      :show="showDetailModal" 
      :item="detailItem" 
      @close="closeDetailModal" 
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import MenuStats from '@/Components/Admin/MenuStats.vue';
import MenuTable from '@/Components/Admin/MenuTable.vue';
import MenuFormModal from '@/Components/Admin/MenuFormModal.vue';
import MenuDetailModal from '@/Components/MenuDetailModal.vue';

const props = defineProps({
  menus: { type: Array, required: true },
  stats: { type: Object, required: true }
});

const showModal = ref(false);
const isEditing = ref(false);
const selectedMenu = ref(null);
const showDetailModal = ref(false);
const detailItem = ref(null);

const openAddModal = () => {
  isEditing.value = false;
  selectedMenu.value = null;
  showModal.value = true;
};

const openEditModal = (menu) => {
  isEditing.value = true;
  selectedMenu.value = menu;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedMenu.value = null;
};

const handleShowDetail = (item) => {
  detailItem.value = item;
  showDetailModal.value = true;
};

const closeDetailModal = () => {
  showDetailModal.value = false;
  detailItem.value = null;
};
</script>