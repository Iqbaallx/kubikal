<template>
  <div class="space-y-6">
    <!-- Stats Cards - Outside Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ galleries.length }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span>Total Foto</span>
        </div>
      </div>

      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ favoritCount }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
          </svg>
          <span>Foto Favorit</span>
        </div>
      </div>
    </div>

    <!-- Main Container Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <!-- Action Button -->
      <div class="flex justify-end mb-6">
        <button
          @click="openAddModal"
          class="group flex items-center gap-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all duration-300 font-medium"
        >
          <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
          <span>Tambah Foto Baru</span>
        </button>
      </div>

      <!-- Gallery Grid -->
      <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div v-if="galleries.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div 
            v-for="gallery in galleries" 
            :key="gallery.id_gallery"
            class="group relative aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300"
          >
            <img 
              :src="gallery.gambar_url" 
              :alt="`Gallery ${gallery.id_gallery}`"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            >
            
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div class="absolute bottom-0 left-0 right-0 p-4">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <button 
                      @click="toggleFavorit(gallery)"
                      class="p-2 bg-white/20 backdrop-blur-sm rounded-lg hover:bg-white/30 transition-all"
                    >
                      <svg 
                        class="w-5 h-5 transition-colors" 
                        :class="gallery.favorit ? 'text-amber-400 fill-amber-400' : 'text-white'"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                      </svg>
                    </button>
                  </div>
                  
                  <button 
                    @click="deleteGallery(gallery)"
                    class="p-2 bg-red-500/80 backdrop-blur-sm rounded-lg hover:bg-red-600 transition-all"
                  >
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Favorit Badge -->
            <div v-if="gallery.favorit" class="absolute top-3 right-3">
              <div class="p-2 bg-amber-400 rounded-lg shadow-lg">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-16">
          <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Foto</h3>
          <p class="text-gray-600 mb-6">Mulai upload foto pertama Anda</p>
          <button
            @click="openAddModal"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-colors"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Foto
          </button>
        </div>
      </div>
    </div>

    <!-- Add Gallery Modal -->
    <GalleryFormModal 
      :show="showModal" 
      @close="closeModal"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import GalleryFormModal from '@/Components/Admin/GalleryFormModal.vue';

const props = defineProps({
  galleries: { type: Array, required: true }
});

const showModal = ref(false);

const favoritCount = computed(() => {
  return props.galleries.filter(g => g.favorit).length;
});

const openAddModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const toggleFavorit = (gallery) => {
  router.put(route('admin.gallery.toggle-favorit', gallery.id_gallery), {}, {
    preserveScroll: true
  });
};

const deleteGallery = (gallery) => {
  if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
    router.delete(route('admin.gallery.destroy', gallery.id_gallery), {
      preserveScroll: true
    });
  }
};
</script>