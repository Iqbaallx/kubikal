<template>
  <div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ stats.totalMenu }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          <span>Total Menu</span>
        </div>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ recentEvents.length }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span>Total Event</span>
        </div>
      </div>

      <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ galleryCount || 0 }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span>Total Foto</span>
        </div>
      </div>
    </div>

    <!-- Menu Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="text-white" style="background-color: #383838;">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold">Foto</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Nama Menu</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Kategori</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Harga</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Deskripsi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="menu in recentMenus" :key="menu.id_menu" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <img :src="menu.gambar_url" :alt="menu.nama_menu" class="w-12 h-12 rounded-lg object-cover">
              </td>
              <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ menu.nama_menu }}</td>
              <td class="px-6 py-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700">
                  {{ formatKategori(menu.kategori) }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-900">Rp {{ menu.harga_menu?.toLocaleString('id-ID') }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ menu.deskripsi_menu }}</td>
            </tr>
            <tr v-if="recentMenus.length === 0">
              <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                Belum ada menu
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Event Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="text-white" style="background-color: #383838;">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold">FOTO</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">NAMA EVENT</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">DESKRIPSI</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">TANGGAL MULAI</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">TANGGAL SELESAI</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">STATUS</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="event in recentEvents" :key="event.id_event" class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4">
                <img :src="event.gambar_url" :alt="event.nama_event" class="w-12 h-12 rounded-lg object-cover">
              </td>
              <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ event.nama_event }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ event.deskripsi_event }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ formatDate(event.tanggal_mulai || event.tanggal) }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ formatDate(event.tanggal_selesai || event.tanggal) }}</td>
              <td class="px-6 py-4">
                <span :class="[
                  'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                  getStatusClass(event)
                ]">
                  {{ getStatus(event) }}
                </span>
              </td>
            </tr>
            <tr v-if="recentEvents.length === 0">
              <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                Belum ada event
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  stats: { type: Object, required: true },
  recentMenus: { type: Array, default: () => [] },
  recentEvents: { type: Array, default: () => [] },
  galleryCount: { type: Number, default: 0 }
});

const formatKategori = (kategori) => {
  const mapping = {
    'makanan': 'Makanan',
    'minuman': 'Minuman',
    'coffee': 'Coffee',
    'non-coffee': 'Non-Coffee',
    'camilan': 'Camilan'
  };
  return mapping[kategori] || kategori;
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
};

const getStatus = (event) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const startDate = new Date(event.tanggal_mulai || event.tanggal);
  startDate.setHours(0, 0, 0, 0);
  
  const endDate = new Date(event.tanggal_selesai || event.tanggal);
  endDate.setHours(0, 0, 0, 0);
  
  if (today < startDate) {
    return 'Segera';
  } else if (today >= startDate && today <= endDate) {
    return 'Berlangsung';
  } else {
    return 'Selesai';
  }
};

const getStatusClass = (event) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const startDate = new Date(event.tanggal_mulai || event.tanggal);
  startDate.setHours(0, 0, 0, 0);
  
  const endDate = new Date(event.tanggal_selesai || event.tanggal);
  endDate.setHours(0, 0, 0, 0);
  
  if (today < startDate) {
    return 'bg-blue-100 text-blue-700';
  } else if (today >= startDate && today <= endDate) {
    return 'bg-green-100 text-green-700';
  } else {
    return 'bg-red-100 text-red-700';
  }
};
</script>