<template>
  <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
    <form @submit.prevent="submitForm" class="max-w-5xl mx-auto">
      <!-- Row 1: Nama Event & Tanggal -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold mb-2 text-gray-700">
            Nama Event <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.nama"
            type="text"
            placeholder="Contoh: Live Music Performance"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all"
            :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.nama }"
            required
          />
          <p v-if="form.errors.nama" class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <span>⚠️</span>
            <span>{{ form.errors.nama }}</span>
          </p>
        </div>
        
        <div>
          <label class="block text-sm font-semibold mb-2 text-gray-700">
            Tanggal <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.tanggal"
            type="date"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all"
            :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.tanggal }"
            required
          />
          <p v-if="form.errors.tanggal" class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <span>⚠️</span>
            <span>{{ form.errors.tanggal }}</span>
          </p>
        </div>
      </div>

      <!-- Row 2: Waktu & Gambar -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold mb-2 text-gray-700">
            Waktu <span class="text-red-500">*</span>
          </label>
          <input
            v-model="form.waktu"
            type="time"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all"
            :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.waktu }"
            required
          />
          <p v-if="form.errors.waktu" class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <span>⚠️</span>
            <span>{{ form.errors.waktu }}</span>
          </p>
        </div>
        
        <div>
          <label class="block text-sm font-semibold mb-2 text-gray-700">
            Gambar Event <span class="text-red-500">*</span>
          </label>
          <div class="flex items-center gap-4">
            <!-- Preview Image -->
            <div class="w-20 h-20 bg-gray-100 rounded-lg border-2 border-gray-300 flex items-center justify-center text-3xl overflow-hidden shadow-sm">
              <img 
                v-if="imagePreview" 
                :src="imagePreview" 
                alt="Preview" 
                class="w-full h-full object-cover" 
              />
              <span v-else class="text-gray-400">📷</span>
            </div>
            
            <!-- Upload Button -->
            <div class="flex-1">
              <input
                type="file"
                ref="fileInput"
                @change="handleFileChange"
                accept="image/*"
                class="hidden"
              />
              <button
                type="button"
                @click="$refs.fileInput.click()"
                class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-3 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2"
              >
                <span>📁</span>
                <span>Pilih File</span>
              </button>
              <div class="text-sm text-gray-600 mt-2">
                {{ form.gambar ? form.gambar.name : 'Belum ada file dipilih' }}
              </div>
            </div>
          </div>
          <p v-if="form.errors.gambar" class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <span>⚠️</span>
            <span>{{ form.errors.gambar }}</span>
          </p>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="mb-8">
        <label class="block text-sm font-semibold mb-2 text-gray-700">
          Deskripsi <span class="text-red-500">*</span>
        </label>
        <textarea
          v-model="form.deskripsi"
          rows="6"
          placeholder="Deskripsikan event Anda secara detail..."
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition-all resize-none"
          :class="{ 'border-red-500 ring-2 ring-red-200': form.errors.deskripsi }"
          required
        />
        <div class="flex justify-between items-center mt-2">
          <p v-if="form.errors.deskripsi" class="text-red-500 text-sm flex items-center gap-1">
            <span>⚠️</span>
            <span>{{ form.errors.deskripsi }}</span>
          </p>
          <span class="text-sm text-gray-500 ml-auto">
            {{ form.deskripsi.length }} karakter
          </span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-4 pt-4 border-t border-gray-200">
        <Link
          :href="route('admin.dashboard', { tab: 'menu' })"
          class="px-6 py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors text-gray-700"
        >
          Batal
        </Link>
        <button
          type="submit"
          :disabled="form.processing"
          class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-3 rounded-lg flex items-center gap-2 font-medium shadow-md transition-all hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="!form.processing">💾</span>
          <span v-else class="animate-spin">⏳</span>
          <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Event' }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  event: {
    type: Object,
    default: () => ({
      nama: '',
      tanggal: '',
      waktu: '',
      deskripsi: '',
      gambar: null
    })
  }
});

const form = useForm({
  nama: props.event.nama || '',
  tanggal: props.event.tanggal || '',
  waktu: props.event.waktu || '',
  deskripsi: props.event.deskripsi || '',
  gambar: null
});

const fileInput = ref(null);
const imagePreview = ref(props.event.gambar_url || null);

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.gambar = file;
    
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const submitForm = () => {
  if (props.event.id) {
    form.post(route('admin.event.update', props.event.id));
  } else {
    form.post(route('admin.event.store'));
  }
};
</script>