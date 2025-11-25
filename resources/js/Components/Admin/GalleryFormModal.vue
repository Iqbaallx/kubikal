<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="show"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        @click.self="close"
      >
        <Transition
          enter-active-class="transition ease-out duration-300"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition ease-in duration-200"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 flex justify-between items-center">
              <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Tambah Foto Gallery</h3>
              </div>
              <button @click="close" class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-xl transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="p-8 overflow-y-auto max-h-[calc(90vh-100px)]">
              <div class="space-y-6">
                <!-- Image Upload Area -->
                <div>
                  <label class="block text-gray-700 font-semibold mb-3">Upload Foto</label>
                  
                  <!-- Preview Image -->
                  <div v-if="previewUrl" class="mb-4">
                    <img 
                      :src="previewUrl" 
                      alt="Preview" 
                      class="w-full h-64 object-cover rounded-xl shadow-lg"
                    >
                  </div>

                  <!-- Upload Area -->
                  <div 
                    @drop.prevent="handleDrop"
                    @dragover.prevent
                    @dragenter.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    :class="[
                      'relative border-2 border-dashed rounded-xl transition-all duration-300 cursor-pointer',
                      isDragging 
                        ? 'border-indigo-500 bg-indigo-50' 
                        : 'border-gray-300 hover:border-indigo-400 bg-gray-50'
                    ]"
                  >
                    <input 
                      id="gambar_gallery" 
                      type="file" 
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                      @change="handleFileSelect"
                      accept="image/*"
                      required
                    />
                    
                    <div class="p-12 text-center">
                      <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <div class="mb-2">
                        <span class="text-indigo-600 font-medium">Klik untuk upload</span>
                        <span class="text-gray-600"> atau drag & drop</span>
                      </div>
                      <p class="text-sm text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                    </div>
                  </div>

                  <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-4 h-3 rounded-full">
                    {{ form.progress.percentage }}%
                  </progress>
                  
                  <InputError :message="form.errors.gambar_gallery" class="mt-2" />
                </div>

                <!-- Favorit Checkbox -->
                <div class="flex items-center p-4 bg-amber-50 rounded-xl border border-amber-200">
                  <input 
                    id="favorit" 
                    type="checkbox" 
                    v-model="form.favorit" 
                    class="w-5 h-5 rounded border-amber-300 text-amber-600 shadow-sm focus:ring-amber-500" 
                  />
                  <label for="favorit" class="ml-3 flex items-center gap-2 text-sm text-gray-900 font-medium">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Jadikan Foto Favorit
                  </label>
                </div>
              </div>

              <!-- Footer -->
              <div class="flex justify-end gap-4 pt-8 mt-8 border-t border-gray-200">
                <button 
                  type="button" 
                  @click="close" 
                  class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors"
                >
                  Batal
                </button>
                <button 
                  type="submit" 
                  :disabled="form.processing || !form.gambar_gallery" 
                  class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ form.processing ? 'Mengupload...' : 'Upload Foto' }}
                </button>
              </div>
            </form>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  show: Boolean
});

const emit = defineEmits(['close']);

const form = useForm({
  gambar_gallery: null,
  favorit: false
});

const isDragging = ref(false);
const previewUrl = ref(null);

const handleFileSelect = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.gambar_gallery = file;
    previewUrl.value = URL.createObjectURL(file);
  }
};

const handleDrop = (event) => {
  isDragging.value = false;
  const file = event.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) {
    form.gambar_gallery = file;
    previewUrl.value = URL.createObjectURL(file);
  }
};

const close = () => {
  emit('close');
  form.reset();
  form.clearErrors();
  previewUrl.value = null;
};

const submit = () => {
  form.post(route('admin.gallery.store'), {
    preserveScroll: true,
    onSuccess: () => close(),
  });
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