<template>
  <Modal :show="show" @close="close" maxWidth="lg">
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Detail Menu</h2>
      <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/3">
          <img :src="menu?.image || defaultImage" :alt="menu?.name || 'Menu Item'" class="rounded-lg shadow-md w-full h-48 object-cover bg-gray-300 dark:bg-gray-700">
          <div class="flex justify-start items-center mt-2">
             <span v-for="n in 2" :key="n" class="text-yellow-400">★</span>
             <span v-for="n in 3" :key="n" class="text-gray-300">★</span>
          </div>
        </div>
        <div class="w-full md:w-2/3">
          <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ menu?.name || 'Nama Menu' }}</h3>
           <span class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-semibold px-2 py-0.5 rounded mb-3">Minuman</span> <div class="mb-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Harga</p>
            <p class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ menu?.price || 'Harga' }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Keterangan</p>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ menu?.description || 'Deskripsi menu...' }}</p>
          </div>
        </div>
      </div>
      <div class="mt-6 text-xs text-gray-500 dark:text-gray-400 border-t pt-4 dark:border-gray-600">
        <p>Ditambahkan: 15 Jan 2025</p> <p>Terakhir diubah: 20 Sep 2025, 14:30</p> </div>
      <div class="mt-6 flex justify-end">
        <SecondaryButton @click="close">
          Tutup
        </SecondaryButton>
      </div>
    </div>
  </Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
  show: Boolean,
  menu: Object, // Data menu yang akan ditampilkan
});

// Perbaikan dari sebelumnya agar tombol tutup berfungsi
const emit = defineEmits(['close']);

const defaultImage = ''; // Ganti dengan URL gambar default jika menu.image kosong

const close = () => {
  emit('close');
};
</script>

<style scoped>
/* Style tambahan jika diperlukan */
</style>