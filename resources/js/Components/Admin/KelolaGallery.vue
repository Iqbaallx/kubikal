<template>
  <div class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex items-center gap-4">
        <div class="text-4xl font-bold text-gray-900">{{ totalImages }}</div>
        <div class="text-sm text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            Total Foto
        </div>
      </div>
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm flex items-center gap-4">
        <div class="text-4xl font-bold text-gray-900">{{ totalFavorites }}</div>
        <div class="text-sm text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
            Total Favorit
        </div>
      </div>
    </div>

    <div class="flex justify-end">
        <input type="file" id="newPhotoUpload" class="hidden" @change="handleUpload" accept="image/*">
        <label for="newPhotoUpload" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg cursor-pointer flex items-center gap-2 transition shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
            <span v-if="uploading">Mengupload...</span>
            <span v-else>Tambah Foto Baru</span>
        </label>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="p-4 font-semibold">Foto</th>
                    <th class="p-4 font-semibold text-center">Favorit</th>
                    <th class="p-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr v-for="img in galleries" :key="img.id_galeri" class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="w-24 h-16 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                            <img :src="img.gambar_url" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <button @click="toggleFavorite(img.id_galeri)" class="focus:outline-none transition transform hover:scale-110">
                            <svg v-if="img.is_favorite" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 hover:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </button>
                    </td>
                    <td class="p-4 text-right">
                        <button @click="deleteGallery(img.id_galeri)" class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm font-medium transition">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr v-if="galleries.length === 0">
                    <td colspan="3" class="p-8 text-center text-gray-500 italic">
                        Belum ada foto di galeri.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination (Optional, if needed later) -->
    <div class="flex justify-end gap-2" v-if="galleries.length > 10">
        <!-- Simple pagination placeholder -->
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
  galleries: { type: Array, required: true }
});

const uploading = ref(false);

const totalImages = computed(() => props.galleries.length);
const totalFavorites = computed(() => props.galleries.filter(g => g.is_favorite).length);

// Fungsi Upload
const handleUpload = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    uploading.value = true;

    const form = useForm({
        gambar: file,
        is_favorite: false // Default not favorite
    });

    form.post(route('admin.galeri.store'), {
        preserveScroll: true,
        onSuccess: () => {
            uploading.value = false;
            event.target.value = ''; // Reset input file
        },
        onError: () => {
            uploading.value = false;
            event.target.value = '';
        }
    });
};

// Fungsi Toggle Favorite
const toggleFavorite = (id) => {
    router.post(route('admin.galeri.toggle-favorite', id), {}, {
        preserveScroll: true
    });
};

// Fungsi Delete
const deleteGallery = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
    router.delete(route('admin.galeri.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>