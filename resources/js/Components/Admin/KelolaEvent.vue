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
          class="group flex items-center gap-3 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 font-medium hover:opacity-90"
          style="background-color: #383838;"
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
          :items="sortedEvents" 
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
import { ref, computed } from 'vue';
import EventTable from '@/Components/Admin/EventTable.vue';
import EventFormModal from '@/Components/Admin/EventFormModal.vue';
import EventDetailModal from '@/Components/EventDetailModal.vue';

const props = defineProps({
  events: { type: Array, required: true }
});

// Sort events: upcoming/ongoing first, completed last
const sortedEvents = computed(() => {
  return [...props.events].sort((a, b) => {
    const now = new Date();
    
    // Helper to get event status
    const getStatus = (event) => {
      const startDate = new Date(event.tanggal_mulai || event.tanggal);
      const endDate = new Date(event.tanggal_selesai || event.tanggal);
      
      if (event.waktu) {
        const [hours, minutes] = event.waktu.split(':');
        startDate.setHours(parseInt(hours), parseInt(minutes), 0);
      }
      
      if (event.waktu_selesai) {
        const [hours, minutes] = event.waktu_selesai.split(':');
        endDate.setHours(parseInt(hours), parseInt(minutes), 0);
      } else {
        endDate.setHours(23, 59, 59);
      }
      
      if (now < startDate) return 'upcoming';
      if (now >= startDate && now <= endDate) return 'ongoing';
      return 'completed';
    };
    
    const statusA = getStatus(a);
    const statusB = getStatus(b);
    
    // Priority: upcoming > ongoing > completed
    const priority = { 'upcoming': 0, 'ongoing': 1, 'completed': 2 };
    return priority[statusA] - priority[statusB];
  });
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