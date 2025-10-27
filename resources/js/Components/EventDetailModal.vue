<script setup>
import Modal from '@/Components/Modal.vue'; //
import SecondaryButton from '@/Components/SecondaryButton.vue'; //

// Props untuk menerima data event
defineProps({
  show: Boolean, // Untuk menampilkan/menyembunyikan modal
  event: Object, // Data event yang akan ditampilkan (harus memiliki 'image' dan 'description')
});

// Emit event 'close' saat tombol tutup diklik
const emit = defineEmits(['close']);

const defaultEventImage = '/images/placeholder-event.jpg'; // Ganti dengan URL gambar default jika event.image kosong

const close = () => {
  emit('close');
};
</script>

<template>
  <Modal :show="show" @close="close" maxWidth="md">
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
      <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ event?.name || 'Detail Event' }}</h2>
      <div class="flex flex-col gap-4">
        <div>
          <img
            :src="event?.image || defaultEventImage"
            :alt="event?.name || 'Gambar Event'"
            class="rounded-lg shadow-md w-full h-48 object-cover bg-gray-300 dark:bg-gray-700 mb-4"
          >
        </div>
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Deskripsi:</p>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ event?.description || 'Deskripsi event belum tersedia.' }}</p>
        </div>
      </div>
      <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 border-t pt-2 dark:border-gray-600">
          <p v-if="event?.date">Tanggal: {{ event.date }}</p>
          <p v-if="event?.time">Waktu: {{ event.time }}</p>
      </div>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="close">
          Tutup
        </SecondaryButton>
      </div>
    </div>
  </Modal>
</template>

<style scoped>
/* Style tambahan jika diperlukan */
img {
  max-height: 200px; /* Batasi tinggi gambar jika perlu */
}
</style>