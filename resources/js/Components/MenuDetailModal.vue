<template>
  <Modal :show="show" @close="close" maxWidth="lg">
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg">
      <!-- Judul -->
      <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Detail Menu</h2>

      <div class="flex flex-col md:flex-row gap-6">
        <!-- Gambar Menu -->
        <div class="w-full md:w-1/3">
          <img
            :src="item?.gambar_url || defaultImage"
            :alt="item?.nama_menu || 'Menu Item'"
            class="rounded-lg shadow-md w-full h-48 object-cover bg-gray-300 dark:bg-gray-700"
          >
        </div>

        <!-- Detail Menu -->
        <div class="w-full md:w-2/3">
          <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">
            {{ item?.nama_menu || 'Nama Menu' }}
          </h3>

          <!-- Kategori -->
          <span class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-semibold px-2 py-0.5 rounded mb-3">
            {{ formatCategory(item?.kategori) || 'Kategori' }}
          </span>

          <!-- Harga -->
          <div class="mb-4">
            <p class="text-sm text-gray-500 dark:text-gray-400">Harga</p>
            <p class="text-lg font-bold text-orange-600 dark:text-orange-400">
              {{ formatCurrency(item?.harga_menu) || 'Rp 0' }}
            </p>
          </div>

          <!-- Deskripsi -->
          <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Keterangan</p>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
              {{ item?.deskripsi_menu || 'Deskripsi menu belum tersedia.' }}
            </p>
          </div>
        </div>
      </div>

      <!-- Informasi Tanggal -->
      <div
        v-if="item?.created_at || item?.updated_at"
        class="mt-6 text-xs text-gray-500 dark:text-gray-400 border-t pt-4 dark:border-gray-600"
      >
        <p v-if="item.created_at">Ditambahkan: {{ formatDate(item.created_at) }}</p>
        <p v-if="item.updated_at">Terakhir diubah: {{ formatDateTime(item.updated_at) }}</p>
      </div>

      <!-- Tombol Tutup -->
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
  show: {
    type: Boolean,
    default: false,
  },
  item: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(['close']);
const defaultImage = '/images/placeholder-menu.jpg';

const close = () => {
  emit('close');
};

// Format kategori, harga, dan tanggal
const formatCategory = (kategori) => {
  if (!kategori) return '';
  const map = {
    coffee: 'Coffee',
    'non-coffee': 'Non-Coffee',
    makanan: 'Makanan',
    camilan: 'Camilan',
  };
  return map[kategori] || kategori;
};

const formatCurrency = (value) => {
  if (!value) value = 0;
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value);
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  }).format(date);
};

const formatDateTime = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  }).format(date);
};
</script>

<style scoped>
img {
  max-height: 200px;
}
</style>
