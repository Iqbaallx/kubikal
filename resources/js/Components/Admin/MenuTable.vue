<template>
  <div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-4 py-3 text-left">Foto</th>
          <th class="px-4 py-3 text-left">Nama Menu</th>
          <th class="px-4 py-3 text-left">Kategori</th>
          <th class="px-4 py-3 text-left">Harga</th>
          <th class="px-4 py-3 text-left">Deskripsi</th>
          <th class="px-4 py-3 text-left">Favorit</th>
          <th class="px-4 py-3 text-left">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr 
          v-for="(item, index) in paginatedItems" 
          :key="item.id"
          :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
        >
          <td class="px-4 py-3">
            <div class="w-10 h-10 bg-amber-100 rounded flex items-center justify-center text-xl overflow-hidden">
              <img v-if="item.foto_url" :src="item.foto_url" alt="" class="w-full h-full object-cover" />
              <span v-else>{{ item.foto || '🍽️' }}</span>
            </div>
          </td>
          <td class="px-4 py-3">{{ item.nama }}</td>
          <td class="px-4 py-3">
            <span class="bg-gray-400 text-white px-3 py-1 rounded-full text-sm">
              {{ item.kategori }}
            </span>
          </td>
          <td class="px-4 py-3">Rp {{ formatCurrency(item.harga) }}</td>
          <td class="px-4 py-3">{{ item.deskripsi }}</td>
          <td class="px-4 py-3">
            <button @click="toggleFavorite(item.id)">
              <span v-if="item.favorit" class="text-yellow-400 text-xl">⭐</span>
              <span v-else class="text-gray-300 text-xl">☆</span>
            </button>
          </td>
          <td class="px-4 py-3">
            <div class="flex gap-2">
              <button
                @click="editItem(item)"
                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm"
              >
                Edit
              </button>
              <button
                @click="deleteItem(item.id)"
                class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-sm"
              >
                Hapus
              </button>
            </div>
          </td>
        </tr>
        <tr v-if="items.length === 0">
          <td colspan="7" class="px-4 py-8 text-center text-gray-500">
            Belum ada menu
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="flex justify-end gap-2 p-4 border-t" v-if="totalPages > 1">
      <button 
        @click="currentPage--"
        :disabled="currentPage === 1"
        :class="[
          'px-3 py-1 rounded',
          currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100',
          'border'
        ]"
      >
        ‹
      </button>
      
      <button 
        v-for="page in totalPages" 
        :key="page"
        @click="currentPage = page"
        :class="[
          'px-3 py-1 rounded',
          currentPage === page ? 'bg-gray-600 text-white' : 'border hover:bg-gray-100'
        ]"
      >
        {{ page }}
      </button>
      
      <button 
        @click="currentPage++"
        :disabled="currentPage === totalPages"
        :class="[
          'px-3 py-1 rounded',
          currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100',
          'border'
        ]"
      >
        ›
      </button>
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

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID').format(value);
};

const toggleFavorite = (id) => {
  router.post(route('admin.menu.toggle-favorite', id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Optional: Show success message
    }
  });
};

const editItem = (item) => {
  emit('edit', item);
  // Atau redirect ke halaman edit
  // router.get(route('admin.menu.edit', item.id));
};

const deleteItem = (id) => {
  if (confirm('Yakin ingin menghapus menu ini?')) {
    router.delete(route('admin.menu.destroy', id), {
      onSuccess: () => {
        // Optional: Show success message
      }
    });
  }
};
</script>