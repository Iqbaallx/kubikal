<template>
  <div class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ totalImages }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <span>Total Semua Foto</span>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-800">Slider Utama (Besar)</h3>
        <span class="px-3 py-1 rounded-full text-xs font-medium" 
              :class="sliderCount >= 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'">
          {{ sliderCount }} / 10 Gambar
        </span>
      </div>

      <div class="mb-6">
        <button 
            @click="openModal('main')"
            :disabled="sliderCount >= 10"
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <p class="mb-1 text-sm text-gray-500 font-semibold">Klik untuk tambah Slider</p>
                <p class="text-xs text-gray-400">Max 10MB per file</p>
            </div>
        </button>
      </div>

      <div v-if="galleries.main && galleries.main.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div v-for="img in galleries.main" :key="img.id_galeri" class="relative group aspect-video rounded-lg overflow-hidden bg-gray-100 shadow">
          <img :src="img.gambar_url" class="w-full h-full object-cover">
          <button @click="deleteGallery(img.id_galeri)" class="absolute inset-0 bg-black/50 text-white opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all font-medium">
            Hapus
          </button>
        </div>
      </div>
      <div v-else class="text-center py-8 text-gray-400 text-sm italic border-2 border-dashed border-gray-100 rounded-lg">
        Belum ada gambar slider.
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-bold text-gray-800 mb-4">Gambar Kecil 1 (Atas)</h3>
          <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden relative mb-4 border border-gray-200">
            <img v-if="galleries.small_1" :src="galleries.small_1.gambar_url" class="w-full h-full object-cover">
            <div v-else class="flex items-center justify-center h-full text-gray-400 text-sm">Kosong</div>
          </div>
          <input type="file" id="s1Upload" class="hidden" @change="(e) => handleDirectUpload(e, 'small_1')" accept="image/*">
          <label for="s1Upload" class="block w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 cursor-pointer transition">
            {{ galleries.small_1 ? 'Ganti Gambar' : 'Upload Gambar' }}
          </label>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="font-bold text-gray-800 mb-4">Gambar Kecil 2 (Bawah)</h3>
          <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden relative mb-4 border border-gray-200">
            <img v-if="galleries.small_2" :src="galleries.small_2.gambar_url" class="w-full h-full object-cover">
            <div v-else class="flex items-center justify-center h-full text-gray-400 text-sm">Kosong</div>
          </div>
          <input type="file" id="s2Upload" class="hidden" @change="(e) => handleDirectUpload(e, 'small_2')" accept="image/*">
          <label for="s2Upload" class="block w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 cursor-pointer transition">
            {{ galleries.small_2 ? 'Ganti Gambar' : 'Upload Gambar' }}
          </label>
        </div>
      </div>

      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold text-gray-800">Galeri Lainnya (Untuk Home & Page Galeri)</h3>
        </div>

        <div class="mb-6">
          <button 
            @click="openModal('standard')"
            class="flex items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all"
          >
             <div class="text-gray-500 font-medium">+ Upload Foto Tambahan</div>
          </button>
        </div>

        <div v-if="galleries.standard && galleries.standard.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="img in galleries.standard" :key="img.id_galeri" class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100 shadow-sm border border-gray-100">
            <img :src="img.gambar_url" class="w-full h-full object-cover">
            
            <div v-if="img.is_favorite" class="absolute top-2 left-2 bg-amber-400 text-white p-1.5 rounded-full shadow-md z-10">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>

            <button @click="deleteGallery(img.id_galeri)" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-7 h-7 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all shadow-md z-10">
              ×
            </button>
          </div>
        </div>
        <div v-else class="text-center py-10 text-gray-400 text-sm">
          Belum ada foto tambahan.
        </div>
      </div>
    </div>

    <GalleryFormModal 
        :show="showModal"
        :tipe="activeModalType"
        @close="showModal = false"
    />

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import GalleryFormModal from '@/Components/Admin/GalleryFormModal.vue';

const props = defineProps({
  galleries: { type: Object, required: true }
});

// State untuk Modal
const showModal = ref(false);
const activeModalType = ref('standard');

const openModal = (type) => {
    activeModalType.value = type;
    showModal.value = true;
};

// Computed
const sliderCount = computed(() => props.galleries.main ? props.galleries.main.length : 0);
const totalImages = computed(() => {
  let count = 0;
  if (props.galleries.main) count += props.galleries.main.length;
  if (props.galleries.standard) count += props.galleries.standard.length;
  if (props.galleries.small_1) count++;
  if (props.galleries.small_2) count++;
  return count;
});

// Fungsi untuk upload gambar kecil (tanpa modal)
const handleDirectUpload = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

    const form = useForm({
        gambar: file,
        tipe: type
    });

    form.post(route('admin.galeri.store'), {
        preserveScroll: true,
        onSuccess: () => event.target.value = '',
    });
};

const deleteGallery = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
    router.delete(route('admin.galeri.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>

<style scoped>
.overflow-y-auto::-webkit-scrollbar {
  width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #818cf8, #a78bfa);
  border-radius: 10px;
}

progress {
  appearance: none;
}

progress::-webkit-progress-bar {
  background-color: #e5e7eb;
  border-radius: 9999px;
}

progress::-webkit-progress-value {
  background: linear-gradient(to right, #818cf8, #a78bfa);
  border-radius: 9999px;
}
</style>