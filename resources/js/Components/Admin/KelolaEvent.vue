<template>
  <div class="space-y-6">
    
    <div class="bg-white rounded-xl p-6 border border-gray-200">
      <div class="text-3xl font-bold text-gray-900 mb-2">{{ events.length }}</div>
      <div class="flex items-center gap-2 text-sm text-gray-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Total Event</span>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      
      <div class="flex justify-end mb-6">
        <button
          @click="openAddModal"
          class="group flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-300 font-medium"
        >
          <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          <span>Tambah Event Baru</span>
        </button>
      </div>

      <!-- Event Table -->
      <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <EventTable 
          :items="events" 
          @edit="openEditModal" 
          @show-detail="handleShowDetail" 
        />
      </div>
    </div>

    <!-- Add/Edit Modal -->
    <EventFormModal 
      :show="showModal" 
      :isEditing="isEditing"
      :formData="selectedEvent"
      @close="closeModal"
    />

    <!-- Detail Modal -->
    <EventDetailModal 
      :show="showDetailModal" 
      :item="detailItem" 
      @close="closeDetailModal" 
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import EventTable from '@/Components/Admin/EventTable.vue';
import EventFormModal from '@/Components/Admin/EventFormModal.vue';
import EventDetailModal from '@/Components/EventDetailModal.vue';

const props = defineProps({
  events: { type: Array, required: true }
});

const showModal = ref(false);
const isEditing = ref(false);
const selectedEvent = ref(null);
const showDetailModal = ref(false);
const detailItem = ref(null);

const openAddModal = () => {
  isEditing.value = false;
  selectedEvent.value = null;
  showModal.value = true;
};

const openEditModal = (event) => {
  isEditing.value = true;
  selectedEvent.value = event;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  selectedEvent.value = null;
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