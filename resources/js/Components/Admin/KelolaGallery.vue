<template>
  <div class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ totalImages }}</div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
          <span>Total Semua Foto</span>
        </div>
      </div>
      <div class="flex items-center justify-end">
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
        <input type="file" id="mainUpload" class="hidden" @change="(e) => handleUpload(e, 'main')" accept="image/*" :disabled="sliderCount >= 10">
        <label for="mainUpload" 
               class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all"
               :class="{'opacity-50 cursor-not-allowed': sliderCount >= 10}">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <p v-if="uploadingType === 'main'" class="text-indigo-600 font-medium">Mengupload...</p>
                <div v-else>
                    <p class="mb-1 text-sm text-gray-500 font-semibold">Klik untuk tambah Slider</p>
                    <p class="text-xs text-gray-400">Max 2MB per file</p>
                </div>
            </div>
        </label>
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
          <input type="file" id="s1Upload" class="hidden" @change="(e) => handleUpload(e, 'small_1')" accept="image/*">
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
          <input type="file" id="s2Upload" class="hidden" @change="(e) => handleUpload(e, 'small_2')" accept="image/*">
          <label for="s2Upload" class="block w-full text-center py-2 px-4 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 cursor-pointer transition">
            {{ galleries.small_2 ? 'Ganti Gambar' : 'Upload Gambar' }}
          </label>
        </div>
      </div>

      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-bold text-gray-800">Galeri Lainnya (Halaman Gallery)</h3>
        </div>

        <div class="mb-6">
          <input type="file" id="stdUpload" class="hidden" @change="(e) => handleUpload(e, 'standard')" accept="image/*">
          <label for="stdUpload" class="flex items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
             <div v-if="uploadingType === 'standard'" class="text-indigo-600 font-medium">Mengupload...</div>
             <div v-else class="text-gray-500 font-medium">+ Upload Foto Tambahan</div>
          </label>
        </div>

        <div v-if="galleries.standard && galleries.standard.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div v-for="img in galleries.standard" :key="img.id_galeri" class="relative group aspect-square rounded-lg overflow-hidden bg-gray-100 shadow-sm">
            <img :src="img.gambar_url" class="w-full h-full object-cover">
            <button @click="deleteGallery(img.id_galeri)" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-7 h-7 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all shadow-md">
              ×
            </button>
          </div>
        </div>
        <div v-else class="text-center py-10 text-gray-400 text-sm">
          Belum ada foto tambahan.
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

// Props sekarang menerima Object, bukan Array
const props = defineProps({
  galleries: { type: Object, required: true }
});

const uploadingType = ref(null);

// Computed Properties untuk Statistik & Validasi
const sliderCount = computed(() => props.galleries.main ? props.galleries.main.length : 0);

const totalImages = computed(() => {
  let count = 0;
  if (props.galleries.main) count += props.galleries.main.length;
  if (props.galleries.standard) count += props.galleries.standard.length;
  if (props.galleries.small_1) count++;
  if (props.galleries.small_2) count++;
  return count;
});

// Fungsi Upload
const handleUpload = (event, type) => {
    const file = event.target.files[0];
    if (!file) return;

    uploadingType.value = type;

    const form = useForm({
        gambar: file,
        tipe: type
    });

    form.post(route('admin.gallery.store'), {
        preserveScroll: true,
        onSuccess: () => {
            uploadingType.value = null;
            event.target.value = ''; // Reset input file
        },
        onError: () => {
            uploadingType.value = null;
            event.target.value = '';
        }
    });
};

// Fungsi Delete
const deleteGallery = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
    router.delete(route('admin.gallery.destroy', id), {
      preserveScroll: true
    });
  }
};
</script>