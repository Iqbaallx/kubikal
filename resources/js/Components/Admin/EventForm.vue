<template>
  <div classfs="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
    <form @submit.prevent="submitEvent">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="space-y-5">
          <div>
            <label for="nama_event" class="block text-sm font-medium text-gray-700 mb-1">Nama Event</label>
            <input 
              type="text" 
              id="nama_event"
              v-model="form.nama_event"
              class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-gray-800 focus:border-gray-800"
              placeholder="Mis: Diskon Kemerdekaan"
            >
            <InputError :message="form.errors.nama_event" class="mt-1" />
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="tanggal_event" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
              <input 
                type="date" 
                id="tanggal_event"
                v-model="form.tanggal_event"
                class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-gray-800 focus:border-gray-800"
              >
              <InputError :message="form.errors.tanggal_event" class="mt-1" />
            </div>
            <div>
              <label for="waktu_event" class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
              <input 
                type="time" 
                id="waktu_event"
                v-model="form.waktu_event"
                class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-gray-800 focus:border-gray-800"
              >
              <InputError :message="form.errors.waktu_event" class="mt-1" />
            </div>
          </div>

          <div>
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea 
              id="deskripsi_event"
              v-model="form.deskripsi_event"
              rows="6"
              class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-gray-800 focus:border-gray-800"
              placeholder="Jelaskan detail event di sini..."
            ></textarea>
            <InputError :message="form.errors.deskripsi_event" class="mt-1" />
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Event</label>
          <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
            <div class="space-y-1 text-center">
              <img 
                v-if="imagePreview"
                :src="imagePreview" 
                alt="Preview Gambar Event" 
                class="mx-auto h-40 w-auto object-cover rounded shadow-md mb-4"
              >
              <svg v-else class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              
              <div class="flex text-sm text-gray-600 justify-center">
                <label for="gambar_event" class="relative cursor-pointer bg-white rounded-md font-medium text-gray-800 hover:text-gray-600">
                  <span>Upload file baru</span>
                  <input 
                    id="gambar_event" 
                    name="gambar_event" 
                    type="file" 
                    class="sr-only"
                    @input="handleFileChange"
                  >
                </label>
                <p class="pl-1">atau drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
            </div>
          </div>
          <InputError :message="form.errors.gambar_event" class="mt-1" />
          
          <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-2">
            {{ form.progress.percentage }}%
          </progress>
        </div>

      </div>

      <div class="flex justify-end pt-6 mt-8 border-t border-gray-200">
        <button 
          type="submit"
          :disabled="form.processing"
          class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-colors"
          :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
        >
          {{ form.processing ? 'Menyimpan...' : 'Update Event' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  event: {
    type: Object,
    required: true
  }
});

const form = useForm({
  _method: 'PUT',
  nama_event: props.event.nama_event,
  tanggal_event: props.event.tanggal_event,
  waktu_event: props.event.waktu_event,
  deskripsi_event: props.event.deskripsi_event,
  gambar_event: null,
});

const imagePreview = ref(props.event.gambar_url);

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.gambar_event = file;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const submitEvent = () => {
  form.post(route('admin.event.update', props.event.id_event), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('gambar_event');
    },
  });
};

watch(() => props.event, (newEvent) => {
  if (!form.processing) {
    form.nama_event = newEvent.nama_event;
    form.tanggal_event = newEvent.tanggal_event;
    form.waktu_event = newEvent.waktu_event;
    form.deskripsi_event = newEvent.deskripsi_event;
    imagePreview.value = newEvent.gambar_url;
  }
}, { deep: true });
</script>