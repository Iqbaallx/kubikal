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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">{{ isEditing ? 'Edit Menu' : 'Tambah Menu Baru' }}</h3>
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
                <div>
                  <InputLabel for="nama_menu" value="Nama Menu" class="text-gray-700 font-semibold mb-2" />
                  <TextInput 
                    id="nama_menu" 
                    v-model="form.nama_menu" 
                    type="text" 
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                    placeholder="Contoh: Espresso" 
                    required 
                  />
                  <InputError :message="form.errors.nama_menu" class="mt-2" />
                </div>

                <div>
                  <InputLabel for="deskripsi_menu" value="Deskripsi" class="text-gray-700 font-semibold mb-2" />
                  <textarea 
                    id="deskripsi_menu" 
                    v-model="form.deskripsi_menu" 
                    rows="3" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" 
                    placeholder="Deskripsikan menu Anda..."
                    required
                  ></textarea>
                  <InputError :message="form.errors.deskripsi_menu" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-6">
                  <div>
                    <InputLabel for="harga_menu" value="Harga" class="text-gray-700 font-semibold mb-2" />
                    <div class="relative">
                      <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                      <TextInput 
                        id="harga_menu" 
                        v-model="form.harga_menu" 
                        type="number" 
                        class="mt-1 block w-full pl-12 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                        placeholder="25000"
                        required 
                      />
                    </div>
                    <InputError :message="form.errors.harga_menu" class="mt-2" />
                  </div>

                  <div>
                    <InputLabel for="kategori" value="Kategori" class="text-gray-700 font-semibold mb-2" />
                    <select 
                      id="kategori" 
                      v-model="form.kategori" 
                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm"
                    >
                      <option value="makanan">Makanan</option>
                      <option value="camilan">Camilan</option>
                      <option value="coffee">Coffee</option>
                      <option value="non-coffee">Non-Coffee</option>
                    </select>
                    <InputError :message="form.errors.kategori" class="mt-2" />
                  </div>
                </div>

                <div>
                  <InputLabel for="gambar_menu" value="Foto Menu" class="text-gray-700 font-semibold mb-2" />
                  <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                    <div class="space-y-1 text-center">
                      <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <div class="flex text-sm text-gray-600">
                        <label for="gambar_menu" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                          <span>Upload file</span>
                          <input id="gambar_menu" type="file" class="sr-only" @input="form.gambar_menu = $event.target.files[0]" accept="image/*" />
                        </label>
                        <p class="pl-1">atau drag and drop</p>
                      </div>
                      <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                    </div>
                  </div>
                  <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-2 h-2 rounded-full">{{ form.progress.percentage }}%</progress>
                  <div v-if="isEditing && form.gambar_url" class="mt-4">
                    <p class="text-sm text-gray-600 font-medium mb-2">Gambar saat ini:</p>
                    <img :src="form.gambar_url" :alt="form.nama_menu" class="w-32 h-32 object-cover rounded-xl shadow-md" />
                  </div>
                  <InputError :message="form.errors.gambar_menu" class="mt-2" />
                </div>

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
                    Jadikan Menu Favorit
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
                  :disabled="form.processing" 
                  class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ form.processing ? 'Menyimpan...' : 'Simpan Menu' }}
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
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  show: Boolean,
  isEditing: Boolean,
  formData: Object
});

const emit = defineEmits(['close']);

const form = useForm({
  id_menu: null,
  nama_menu: '',
  deskripsi_menu: '',
  harga_menu: 0,
  kategori: 'makanan',
  favorit: false,
  gambar_menu: null,
  gambar_url: null,
});

watch(() => props.formData, (data) => {
  if (data) {
    form.id_menu = data.id_menu;
    form.nama_menu = data.nama_menu;
    form.deskripsi_menu = data.deskripsi_menu;
    form.harga_menu = data.harga_menu;
    form.kategori = data.kategori;
    form.favorit = data.favorit;
    form.gambar_url = data.gambar_url;
    form.gambar_menu = null;
  } else {
    form.reset();
    form.kategori = 'makanan';
  }
});

const close = () => {
  emit('close');
  form.reset();
  form.clearErrors();
};

const submit = () => {
  if (props.isEditing) {
    form.put(route('admin.menu.update', form.id_menu), {
      preserveScroll: true,
      onSuccess: () => close(),
    });
  } else {
    form.post(route('admin.menu.store'), {
      preserveScroll: true,
      onSuccess: () => close(),
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

progress::-webkit-progress-bar {
  background-color: #e5e7eb;
  border-radius: 9999px;
}

progress::-webkit-progress-value {
  background: linear-gradient(to right, #818cf8, #a78bfa);
  border-radius: 9999px;
}
</style>