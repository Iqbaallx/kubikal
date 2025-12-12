<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="text-white" style="background-color: #383838;">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">Gambar</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Nama Event</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Waktu</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="(item, index) in items" 
            :key="item.id_event"
            :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
          >
            <td class="px-6 py-3">
              <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center text-xl overflow-hidden">
                <img v-if="item.gambar_url" :src="item.gambar_url" :alt="item.nama_event" class="w-full h-full object-cover" />
                <span v-else>🎉</span>
              </div>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">
              <a 
                href="#" 
                @click.prevent="showDetail(item)" 
                class="font-medium text-gray-900 hover:text-amber-600 hover:underline"
              >
                {{ item.nama_event }}
              </a>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">{{ formatDateRange(item) }}</td>
            <td class="px-6 py-3 text-sm text-gray-900">{{ formatTimeRange(item) }}</td>
            <td class="px-6 py-3">
              <span :class="[
                'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                getStatusClass(item)
              ]">
                {{ getStatus(item) }}
              </span>
            </td>
            <td class="px-6 py-3">
              <div class="flex gap-2">
                <button
                  @click="showDetail(item)"
                  class="bg-amber-600 hover:bg-amber-700 text-white px-3 py-1.5 rounded text-xs"
                >
                  Detail
                </button>
                <button
                  @click="editItem(item)"
                  class="text-white px-3 py-1.5 rounded text-xs" style="background-color: #383838;"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(item.id_event)"
                  class="text-white px-3 py-1.5 rounded text-xs hover:opacity-90" style="background-color: #383838;"
                >
                  Hapus
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="items.length === 0">
            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
              Belum ada event
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
  items: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['edit', 'show-detail']);

const formatDate = (dateString) => {
  if (!dateString || dateString === '0000-00-00' || dateString === 'null') {
    return '-';
  }
  const options = { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' };
  const date = new Date(dateString);
  if (isNaN(date.getTime())) {
    return '-';
  }
  return date.toLocaleDateString('id-ID', options);
};

const formatTime = (timeString) => {
  if (!timeString || timeString === 'null') {
    return '-';
  }
  const parts = timeString.split(':');
  if (parts.length >= 2) {
    return `${parts[0]}:${parts[1]}`;
  }
  return timeString;
};

const formatDateRange = (item) => {
  const formatSingleDate = (dateString) => {
    if (!dateString || dateString === '0000-00-00' || dateString === 'null') return null;
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return null;
    return date.toLocaleDateString('id-ID', { 
      day: 'numeric', 
      month: 'short', 
      year: 'numeric' 
    });
  };

  const startDate = formatSingleDate(item.tanggal_mulai);
  const endDate = formatSingleDate(item.tanggal_selesai);

  if (startDate && endDate) {
    return `${startDate} - ${endDate}`;
  } else if (startDate) {
    return startDate;
  } else if (item.tanggal) {
    return formatSingleDate(item.tanggal) || '-';
  }
  return '-';
};

const formatTimeRange = (item) => {
  const formatSingleTime = (timeString) => {
    if (!timeString || timeString === 'null') return null;
    const parts = timeString.split(':');
    if (parts.length >= 2) {
      return `${parts[0]}.${parts[1]}`;
    }
    return timeString;
  };

  const startTime = formatSingleTime(item.waktu);
  const endTime = formatSingleTime(item.waktu_selesai);

  if (startTime && endTime) {
    return `${startTime} - ${endTime}`;
  } else if (startTime) {
    return startTime;
  }
  return '-';
};

const showDetail = (item) => {
  emit('show-detail', item);
};

const editItem = (item) => {
  emit('edit', item);
};

const getStatus = (item) => {
  const now = new Date();
  
  // Parse start date with time
  const startDate = new Date(item.tanggal_mulai || item.tanggal);
  if (item.waktu) {
    const [hours, minutes] = item.waktu.split(':');
    startDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else {
    startDate.setHours(0, 0, 0, 0);
  }
  
  // Parse end date with time
  const endDate = new Date(item.tanggal_selesai || item.tanggal);
  if (item.waktu_selesai) {
    const [hours, minutes] = item.waktu_selesai.split(':');
    endDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else if (item.waktu) {
    const [hours, minutes] = item.waktu.split(':');
    endDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else {
    endDate.setHours(23, 59, 59, 999);
  }
  
  if (now < startDate) {
    return 'Segera';
  } else if (now >= startDate && now <= endDate) {
    return 'Berlangsung';
  } else {
    return 'Selesai';
  }
};

const getStatusClass = (item) => {
  const now = new Date();
  
  // Parse start date with time
  const startDate = new Date(item.tanggal_mulai || item.tanggal);
  if (item.waktu) {
    const [hours, minutes] = item.waktu.split(':');
    startDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else {
    startDate.setHours(0, 0, 0, 0);
  }
  
  // Parse end date with time
  const endDate = new Date(item.tanggal_selesai || item.tanggal);
  if (item.waktu_selesai) {
    const [hours, minutes] = item.waktu_selesai.split(':');
    endDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else if (item.waktu) {
    const [hours, minutes] = item.waktu.split(':');
    endDate.setHours(parseInt(hours), parseInt(minutes), 0);
  } else {
    endDate.setHours(23, 59, 59, 999);
  }
  
  if (now < startDate) {
    return 'bg-blue-100 text-blue-700';
  } else if (now >= startDate && now <= endDate) {
    return 'bg-green-100 text-green-700';
  } else {
    return 'bg-gray-200 text-gray-700';
  }
};

const deleteItem = (id) => {
  if (confirm('Yakin ingin menghapus event ini?')) {
    router.delete(route('admin.event.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>