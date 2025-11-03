<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-800 text-white">
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
            :key="item.id"
            :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
          >
            <td class="px-6 py-3">
              <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center text-xl overflow-hidden">
                <img v-if="item.foto_url" :src="item.foto_url" alt="" class="w-full h-full object-cover" />
                <span v-else>{{ item.foto || '🍽️' }}</span>
              </div>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">{{ item.nama }}</td>
            <td class="px-6 py-3">
              <span 
                :class="[
                  'px-3 py-1 rounded-full text-xs',
                  item.kategori === 'Minuman' ? 'bg-gray-400 text-white' : 'bg-gray-500 text-white'
                ]"
              >
                {{ item.kategori }}
              </span>
            </td>
            <td class="px-6 py-3 text-sm text-gray-900">
              Rp {{ formatCurrency(item.harga) }}
            </td>
            <td class="px-6 py-3 text-sm text-gray-600">
              {{ item.deskripsi }}
            </td>
            <td class="px-6 py-3">
              <button 
                @click="toggleFavorite(item.id)"
                class="text-xl"
              >
                <span v-if="item.favorit" class="text-yellow-400">⭐</span>
                <span v-else class="text-gray-300">☆</span>
              </button>
            </td>
            <td class="px-6 py-3">
              <div class="flex gap-2">
                <button
                  @click="editItem(item)"
                  class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-xs"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(item.id)"
                  class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded text-xs"
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

    <!-- Pagination -->
    <div class="flex justify-between items-center px-6 py-4 bg-gray-50 border-t border-gray-200" v-if="totalPages > 1">
      <div class="text-sm text-gray-600">
        Menampilkan {{ startItem }}-{{ endItem }} dari {{ items.length }} menu
      </div>
      <div class="flex gap-2">
        <button 
          @click="currentPage--"
          :disabled="currentPage === 1"
          :class="[
            'px-4 py-2 rounded-lg font-medium text-sm transition-colors',
            currentPage === 1 
              ? 'opacity-40 cursor-not-allowed bg-gray-200 text-gray-500' 
              : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-300'
          ]"
        >
          ← Prev
        </button>
        
        <button 
          v-for="page in visiblePages" 
          :key="page"
          @click="currentPage = page"
          :class="[
            'px-4 py-2 rounded-lg font-medium text-sm transition-all',
            currentPage === page 
              ? 'bg-gray-800 text-white shadow-md' 
              : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-300'
          ]"
        >
          {{ page }}
        </button>
        
        <button 
          @click="currentPage++"
          :disabled="currentPage === totalPages"
          :class="[
            'px-4 py-2 rounded-lg font-medium text-sm transition-colors',
            currentPage === totalPages 
              ? 'opacity-40 cursor-not-allowed bg-gray-200 text-gray-500' 
              : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-300'
          ]"
        >
          Next →
        </button>
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

const emit = defineEmits(['edit']);

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

const deleteItem = (id) => {
  if (confirm('Yakin ingin menghapus menu ini?')) {
    router.delete(route('admin.menu.destroy', id));
  }
};
</script>