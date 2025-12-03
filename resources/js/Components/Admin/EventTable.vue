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
            <td class="px-6 py-3 text-sm text-gray-900">{{ formatDate(item.tanggal) }}</td>
            <td class="px-6 py-3 text-sm text-gray-900">{{ formatTime(item.waktu) }}</td>
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
            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
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

const showDetail = (item) => {
  emit('show-detail', item);
};

const editItem = (item) => {
  emit('edit', item);
};

const deleteItem = (id) => {
  if (confirm('Yakin ingin menghapus event ini?')) {
    router.delete(route('admin.event.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>