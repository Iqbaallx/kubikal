<template>
  <div class="bg-white p-8 rounded-b-lg shadow-lg">
    <form @submit.prevent="submitForm" class="max-w-4xl">
      <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-medium mb-2">Nama Event</label>
          <input
            v-model="form.nama"
            type="text"
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
            :class="{ 'border-red-500': form.errors.nama }"
            required
          />
          <p v-if="form.errors.nama" class="text-red-500 text-sm mt-1">
            {{ form.errors.nama }}
          </p>
        </div>
        
        <div>
          <label class="block text-sm font-medium mb-2">Tanggal</label>
          <input
            v-model="form.tanggal"
            type="date"
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
            :class="{ 'border-red-500': form.errors.tanggal }"
            required
          />
          <p v-if="form.errors.tanggal" class="text-red-500 text-sm mt-1">
            {{ form.errors.tanggal }}
          </p>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-medium mb-2">Waktu</label>
          <input
            v-model="form.waktu"
            type="time"
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
            :class="{ 'border-red-500': form.errors.waktu }"
            required
          />
          <p v-if="form.errors.waktu" class="text-red-500 text-sm mt-1">
            {{ form.errors.waktu }}
          </p>
        </div>
        
        <div>
          <label class="block text-sm font-medium mb-2">Gambar Event</label>
          <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gray-100 rounded border flex items-center justify-center text-2xl overflow-hidden">
              <img v-if="imagePreview" :src="imagePreview" alt="Preview" class="w-full h-full object-cover" />
              <span v-else>📷</span>
            </div>
            <div>
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
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm"
              >
                Choose File
              </button>
              <div class="text-sm text-gray-500 mt-1">
                {{ form.gambar ? form.gambar.name : 'No file chosen' }}
              </div>
            </div>
          </div>
          <p v-if="form.errors.gambar" class="text-red-500 text-sm mt-1">
            {{ form.errors.gambar }}
          </p>
        </div>
      </div>

      <div class="mb-6">
        <label class="block text-sm font-medium mb-2">Deskripsi</label>
        <textarea
          v-model="form.deskripsi"
          rows="6"
          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-gray-400"
          :class="{ 'border-red-500': form.errors.deskripsi }"
          required
        />
        <p v-if="form.errors.deskripsi" class="text-red-500 text-sm mt-1">
          {{ form.errors.deskripsi }}
        </p>
      </div>

      <div class="flex justify-end gap-3">
        <Link
          :href="route('admin.event.index')"
          class="px-6 py-2 border rounded hover:bg-gray-100"
        >
          Batal
        </Link>
        <button
          type="submit"
          :disabled="form.processing"
          class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded flex items-center gap-2 disabled:opacity-50"
        >
          <span>💾</span>
          <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
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
    
    // Create preview
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