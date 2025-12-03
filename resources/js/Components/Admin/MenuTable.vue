<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="text-white" style="background-color: #383838;">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">Foto</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Nama Menu</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Kategori</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Harga</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Deskripsi</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Favorit</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr 
            v-for="(item, index) in paginatedItems" 
            :key="item.id_menu"
            :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
          >
            <td class="px-6 py-3">
              <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center text-xl overflow-hidden">
                <img v-if="item.gambar_url" :src="item.gambar_url" :alt="item.nama_menu" class="w-full h-full object-cover" />
                <span v-else>🍽️</span>
              </div>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">
              <a 
                href="#" 
                @click.prevent="showDetail(item)" 
                class="font-medium text-gray-900 hover:text-amber-600 hover:underline"
              >
                {{ item.nama_menu }}
              </a>
            </td>
            <td class="px-6 py-3">
              <span 
                :class="[
                  'px-3 py-1 rounded-full text-xs',
                  item.kategori === 'coffee' || item.kategori === 'non-coffee' ? 'bg-gray-400 text-white' : 'bg-gray-500 text-white'
                ]"
              >
                {{ item.kategori }}
              </span>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">
              Rp {{ formatCurrency(item.harga_menu) }}
            </td>
            <td class="px-6 py-3 text-sm text-gray-600 truncate max-w-xs">
              {{ item.deskripsi_menu }}
            </td>
            <td class="px-6 py-3">
              <button 
                @click="toggleFavorite(item.id_menu)"
                class="text-xl"
              >
                <span v-if="item.favorit" class="text-yellow-400">⭐</span>
                <span v-else class="text-gray-300">☆</span>
              </button>
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
                  @click="deleteItem(item.id_menu)"
                  class="text-white px-3 py-1.5 rounded text-xs hover:opacity-90" style="background-color: #383838;"
                >
                  Hapus
                </button>
              </div>
            </td>
          </tr>
          <tr v-if="items.length === 0">
            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
              Belum ada menu
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex justify-between items-center px-6 py-4 bg-gray-50 border-t border-gray-200" v-if="totalPages > 1">
      <div class="text-sm text-gray-600">
        Menampilkan {{ startItem }}-{{ endItem }} dari {{ items.length }} menu
      </div>
      <div class="flex gap-2">
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  items: {
    type: Array,
    required: true
  }
});

// Tambahkan 'show-detail' ke emits
const emit = defineEmits(['edit', 'show-detail']);

const currentPage = ref(1);
const itemsPerPage = 10;

const totalPages = computed(() => {
  return Math.ceil(props.items.length / itemsPerPage);
});

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return props.items.slice(start, end);
});

const startItem = computed(() => {
  if (props.items.length === 0) return 0;
  return (currentPage.value - 1) * itemsPerPage + 1;
});

const endItem = computed(() => {
  return Math.min(currentPage.value * itemsPerPage, props.items.length);
});

const visiblePages = computed(() => {
  const pages = [];
  const maxVisible = 5;
  let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
  let end = Math.min(totalPages.value, start + maxVisible - 1);
  
  if (end - start < maxVisible - 1) {
    start = Math.max(1, end - maxVisible + 1);
  }
  
  for (let i = start; i <= end; i++) {
    pages.push(i);
  }
  return pages;
});

const formatCurrency = (value) => {
  if (value === null || value === undefined) {
    value = 0;
  }
  return new Intl.NumberFormat('id-ID').format(value);
};

const toggleFavorite = (id) => {
  router.post(route('admin.menu.toggle-favorite', id), {}, {
    preserveScroll: true
  });
};

const editItem = (item) => {
  emit('edit', item);
};

// Fungsi ini dipanggil oleh nama DAN tombol "Detail"
const showDetail = (item) => {
  emit('show-detail', item);
};

const deleteItem = (id) => {
  if (confirm('Yakin ingin menghapus menu ini?')) {
    router.delete(route('admin.menu.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>

<style scoped>
.truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>