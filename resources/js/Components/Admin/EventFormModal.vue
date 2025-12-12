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
            <div class="px-8 py-6 flex justify-between items-center" style="background-color: #383838;">
              <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">{{ isEditing ? 'Edit Event' : 'Tambah Event Baru' }}</h3>
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
                  <InputLabel for="nama_event" value="Nama Event" class="text-gray-700 font-semibold mb-2" />
                  <TextInput 
                    id="nama_event" 
                    v-model="form.nama_event" 
                    type="text" 
                    class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                    placeholder="Contoh: Live Music Jazz"
                    required 
                  />
                  <InputError :message="form.errors.nama_event" class="mt-2" />
                </div>

                <div>
                  <InputLabel for="deskripsi_event" value="Deskripsi" class="text-gray-700 font-semibold mb-2" />
                  <textarea 
                    id="deskripsi_event" 
                    v-model="form.deskripsi_event" 
                    rows="4" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm" 
                    placeholder="Deskripsikan event Anda..."
                    required
                  ></textarea>
                  <InputError :message="form.errors.deskripsi_event" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-6">
                  <div>
                    <InputLabel for="tanggal_mulai" value="Tanggal Mulai" class="text-gray-700 font-semibold mb-2" />
                    <TextInput 
                      id="tanggal_mulai" 
                      v-model="form.tanggal_mulai" 
                      type="date" 
                      :min="today"
                      class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                      required 
                    />
                    <InputError :message="form.errors.tanggal_mulai" class="mt-2" />
                  </div>

                  <div>
                    <InputLabel for="tanggal_selesai" value="Tanggal Selesai" class="text-gray-700 font-semibold mb-2" />
                    <TextInput 
                      id="tanggal_selesai" 
                      v-model="form.tanggal_selesai" 
                      type="date" 
                      :min="form.tanggal_mulai || today"
                      class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                      required 
                    />
                    <InputError :message="form.errors.tanggal_selesai" class="mt-2" />
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                  <div>
                    <InputLabel for="waktu" value="Waktu Mulai" class="text-gray-700 font-semibold mb-2" />
                    <TextInput 
                      id="waktu" 
                      v-model="form.waktu" 
                      type="time" 
                      class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                      required
                    />
                    <InputError :message="form.errors.waktu" class="mt-2" />
                  </div>

                  <div>
                    <InputLabel for="waktu_selesai" value="Waktu Selesai" class="text-gray-700 font-semibold mb-2" />
                    <TextInput 
                      id="waktu_selesai" 
                      v-model="form.waktu_selesai" 
                      type="time" 
                      class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" 
                      :class="{ 'border-red-500': timeValidationError }"
                    />
                    <InputError :message="form.errors.waktu_selesai || timeValidationError" class="mt-2" />
                  </div>
                </div>

                <div>
                  <InputLabel for="gambar_event" value="Gambar Event" class="text-gray-700 font-semibold mb-2" />
                  <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-indigo-400 transition-colors">
                    <div class="space-y-1 text-center">
                      <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <div class="flex text-sm text-gray-600">
                        <label for="gambar_event" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                          <span>Upload file</span>
                          <input id="gambar_event" type="file" class="sr-only" @input="form.gambar_event = $event.target.files[0]" accept="image/*" />
                        </label>
                        <p class="pl-1">atau drag and drop</p>
                      </div>
                      <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                    </div>
                  </div>
                  <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-2 h-2 rounded-full">{{ form.progress.percentage }}%</progress>
                  <div v-if="isEditing && form.gambar_url" class="mt-4">
                    <p class="text-sm text-gray-600 font-medium mb-2">Gambar saat ini:</p>
                    <img :src="form.gambar_url" :alt="form.nama_event" class="w-40 h-auto object-cover rounded-xl shadow-md" />
                  </div>
                  <InputError :message="form.errors.gambar_event" class="mt-2" />
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
                  :disabled="form.processing || !!timeValidationError" 
                  class="px-6 py-3 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed hover:opacity-90" style="background-color: #383838;"
                >
                  {{ form.processing ? 'Menyimpan...' : 'Simpan Event' }}
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
import { watch, computed } from 'vue';
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
  id_event: null,
  nama_event: '',
  deskripsi_event: '',
  tanggal: '',
  waktu: '',
  waktu_selesai: '',
  tanggal_mulai: '',
  tanggal_selesai: '',
  gambar_event: null,
  gambar_url: null,
});

// Get today's date in YYYY-MM-DD format for min attribute
const today = new Date().toISOString().split('T')[0];

// Time validation
const timeValidationError = computed(() => {
  if (form.waktu && form.waktu_selesai) {
    const [startHour, startMin] = form.waktu.split(':').map(Number);
    const [endHour, endMin] = form.waktu_selesai.split(':').map(Number);
    const startMinutes = startHour * 60 + startMin;
    const endMinutes = endHour * 60 + endMin;
    
    if (endMinutes <= startMinutes) {
      return 'Waktu selesai harus lebih lambat dari waktu mulai';
    }
  }
  return null;
});

watch(() => props.formData, (data) => {
  if (data) {
    form.id_event = data.id_event;
    form.nama_event = data.nama_event;
    form.deskripsi_event = data.deskripsi_event;
    form.tanggal = data.tanggal;
    form.waktu = data.waktu;
    form.waktu_selesai = data.waktu_selesai || '';
    form.tanggal_mulai = data.tanggal_mulai || '';
    form.tanggal_selesai = data.tanggal_selesai || '';
    form.gambar_url = data.gambar_url;
    form.gambar_event = null;
  } else {
    form.reset();
  }
});

const close = () => {
  emit('close');
  form.reset();
  form.clearErrors();
};

const submit = () => {
  if (props.isEditing) {
    // FIX: Use POST with _method workaround because PUT doesn't support file uploads in Inertia
    form.post(route('admin.event.update', form.id_event), {
      _method: 'PUT',
      preserveScroll: true,
      onSuccess: () => close(),
    });
  } else {
    form.post(route('admin.event.store'), {
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
  background: #383838;
  border-radius: 10px;
}

progress::-webkit-progress-bar {
  background-color: #e5e7eb;
  border-radius: 9999px;
}

progress::-webkit-progress-value {
  background: #383838;
  border-radius: 9999px;
}
</style>