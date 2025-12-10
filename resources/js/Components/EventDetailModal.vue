<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
  show: { type: Boolean, default: false },
  item: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['close']);
const defaultEventImage = '/images/placeholder-event.jpg';
const close = () => { emit('close'); };
</script>

<template>
  <Modal :show="show" @close="close" maxWidth="md">
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
      <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ item?.nama_event || 'Detail Event' }}</h2>
      <div class="flex flex-col gap-4">
        <div>
          <img :src="item?.gambar_url || defaultEventImage" :alt="item?.nama_event || 'Gambar Event'" class="rounded-lg shadow-md w-full h-48 object-cover bg-gray-300 dark:bg-gray-700 mb-4">
        </div>
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Deskripsi:</p>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ item?.deskripsi_event || 'Deskripsi event belum tersedia.' }}</p>
        </div>
      </div>
      <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 border-t pt-2 dark:border-gray-600">
        <p v-if="item?.tanggal_mulai && item?.tanggal_selesai">Tanggal: {{ formatDate(item.tanggal_mulai) }} sampai {{ formatDate(item.tanggal_selesai) }}</p>
        <p v-else-if="item?.tanggal_mulai">Tanggal: {{ formatDate(item.tanggal_mulai) }}</p>
        <p v-else-if="item?.tanggal">Tanggal: {{ formatDate(item.tanggal) }}</p>
        <p v-if="item?.waktu">Waktu: {{ formatTimeRange(item) }} WIB</p>
      </div>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="close">Tutup</SecondaryButton>
      </div>
    </div>
  </Modal>
</template>

<script>
export default {
  methods: {
    formatDate(dateString) {
      if (!dateString || dateString === '0000-00-00' || dateString === 'null') return 'Tanggal tidak valid';
      const options = { year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' };
      const date = new Date(dateString);
      if (isNaN(date.getTime())) return 'Tanggal tidak valid';
      return date.toLocaleDateString('id-ID', options);
    },
    formatTime(timeString) {
      if (!timeString || timeString === 'null') return '--:--';
      const parts = timeString.split(':');
      if (parts.length >= 2) return parts[0] + ':' + parts[1];
      return timeString;
    },
    formatTimeRange(item) {
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
      return '--:--';
    },
  },
};
</script>

<style scoped>
img { max-height: 200px; }
</style>
