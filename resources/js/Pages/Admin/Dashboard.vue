<template>
  <AdminLayout>
    <div class="flex min-h-screen" style="background: linear-gradient(0deg, #F5F5F4, #F5F5F4), #FFFFFF;">
      <!-- Main Content Area -->
      <div class="flex-1 flex flex-col ml-44">
        <!-- Fixed Header -->
        <div class="mx-8 mt-4 mb-2">
          <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-8 py-3.5 flex justify-between items-center rounded-full shadow-lg">
            <h1 class="text-lg font-medium">
              {{ activeTab === 'menu' ? 'Kelola Menu' : 'Kelola Event' }}
            </h1>
            <div class="flex items-center gap-3">
              <span class="text-sm font-normal">Halo</span>
              <div class="w-8 h-8 bg-amber-600 rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-2 ring-amber-400">
                {{ initials }}
              </div>
            </div>
          </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto">
          <div class="p-8 max-w-[1600px] mx-auto">
            <!-- Menu Tab Content -->
            <div v-show="activeTab === 'menu'">
              <!-- Stats Cards Grid -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.totalMenu }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2">
                    <span>Total Menu</span>
                  </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.minuman }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2">
                    <span>Minuman</span>
                  </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.makanan }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2">
                    <span>Makanan</span>
                  </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.favorit }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2">
                    <span>Menu Favorit</span>
                  </div>
                </div>
              </div>

              <!-- Action Bar -->
              <div class="flex justify-end mb-6">
                <button
                  @click="showAddMenuModal = true"
                  class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm transition-colors"
                >
                  <span>+</span>
                  <span>Tambah Menu Baru</span>
                </button>
              </div>

              <!-- Menu Table -->
              <MenuTable :items="menus" @edit="handleEditMenu" />
            </div>

            <!-- Event Tab Content -->
            <div v-show="activeTab === 'event'">
              <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Edit Event</h2>
                <p class="text-gray-600 text-sm">Kelola informasi event Kubikal Space</p>
              </div>
              
              <EventForm :event="event" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Menu Modal (Optional) -->
    <Teleport to="body">
      <div
        v-if="showAddMenuModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="showAddMenuModal = false"
      >
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
            <h3 class="text-xl font-bold">Tambah Menu Baru</h3>
            <button
              @click="showAddMenuModal = false"
              class="text-white hover:text-gray-300 text-2xl leading-none"
            >
              ×
            </button>
          </div>
          
          <div class="p-6">
            <!-- Menu Form Here -->
            <p class="text-gray-500 text-center py-8">
              Form tambah menu akan ditampilkan di sini
            </p>
          </div>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
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

// Reactive current tab
const activeTab = computed(() => {
  // Prioritas: props.currentTab dari backend
  if (props.currentTab) {
    return props.currentTab;
  }
  
  // Fallback: cek URL parameter
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  
  return tabParam || 'menu';
});

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

const handleEditMenu = (item) => {
  console.log('Edit menu:', item);
};

// Debug log untuk melihat tab aktif
onMounted(() => {
  console.log('Current active tab:', activeTab.value);
});
</script>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>