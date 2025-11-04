<template>
  <AdminLayout>
    <div class="flex min-h-screen" style="background: linear-gradient(0deg, #F5F5F4, #F5F5F4), #FFFFFF;">
      <div class="flex-1 flex flex-col ml-44">
        <div class="mx-8 mt-4 mb-2">
          <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-8 py-3.5 flex justify-between items-center rounded-full shadow-lg">
            <h1 class="text-lg font-medium">
              {{ activeTab === 'menu' ? 'Kelola Menu' : 'Kelola Event' }}
            </h1>
            <div class="flex items-center gap-3">
              <span class="text-sm font-normal">Halo</span>
              <div class="w-8 h-8 bg-amber-600 rounded-full flex items-center justify-center font-bold text-sm shadow-md ring-2 ring-amber-400">
                {{ initials }}
              </div>
            </div>
          </div>
        </div>

        <div class="flex-1 overflow-y-auto">
          <div class="p-8 max-w-[1600px] mx-auto">
            <div v-show="activeTab === 'menu'">
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.totalMenu }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2"><span>Total Menu</span></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.minuman }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2"><span>Minuman</span></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.makanan }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2"><span>Makanan</span></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                  <div class="text-3xl font-semibold mb-1 text-gray-900">{{ stats.favorit }}</div>
                  <div class="text-gray-600 text-sm flex items-center gap-2"><span>Menu Favorit</span></div>
                </div>
              </div>
              <div class="flex justify-end mb-6">
                <button
                  @click="openAddModal"
                  class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm transition-colors"
                >
                  <span>+</span>
                  <span>Tambah Menu Baru</span>
                </button>
              </div>
              <MenuTable :items="menus" @edit="openEditModal" />
            </div>

            <div v-show="activeTab === 'event'">
              <div class="flex justify-end mb-6">
                <button
                  @click="openAddEventModal"
                  class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 text-sm transition-colors"
                >
                  <span>+</span>
                  <span>Tambah Event Baru</span>
                </button>
              </div>
              <EventTable :items="events" @edit="openEditEventModal" />
            </div>
            
          </div>
        </div>
      </div>
    </div>

    <Teleport to="body">
      <div
        v-if="showAddMenuModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="closeModal"
      >
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
            <h3 class="text-xl font-bold">{{ isEditing ? 'Edit Menu' : 'Tambah Menu Baru' }}</h3>
            <button @click="closeModal" class="text-white hover:text-gray-300 text-2xl leading-none">×</button>
          </div>
          <form @submit.prevent="submitMenu" class="p-6">
            <div class="space-y-4">
              <div>
                <InputLabel for="nama_menu" value="Nama Menu" />
                <TextInput id="nama_menu" v-model="form.nama_menu" type="text" class="mt-1 block w-full" required />
                <InputError :message="form.errors.nama_menu" class="mt-2" />
              </div>
              <div>
                <InputLabel for="deskripsi_menu" value="Deskripsi" />
                <textarea id="deskripsi_menu" v-model="form.deskripsi_menu" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                <InputError :message="form.errors.deskripsi_menu" class="mt-2" />
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <InputLabel for="harga_menu" value="Harga" />
                  <TextInput id="harga_menu" v-model="form.harga_menu" type="number" class="mt-1 block w-full" required />
                  <InputError :message="form.errors.harga_menu" class="mt-2" />
                </div>
                <div>
                  <InputLabel for="kategori" value="Kategori" />
                  <select id="kategori" v-model="form.kategori" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="makanan">Makanan</option>
                    <option value="camilan">Camilan</option>
                    <option value="coffee">Coffee</option>
                    <option value="non-coffee">Non-Coffee</option>
                  </select>
                  <InputError :message="form.errors.kategori" class="mt-2" />
                </div>
              </div>
              <div>
                <InputLabel for="gambar_menu" value="Foto Menu" />
                <input id="gambar_menu" type="file" @input="form.gambar_menu = $event.target.files[0]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-2">{{ form.progress.percentage }}%</progress>
                <div v-if="isEditing && form.gambar_url" class="mt-2">
                  <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                  <img :src="form.gambar_url" :alt="form.nama_menu" class="w-24 h-24 object-cover rounded shadow" />
                </div>
                <InputError :message="form.errors.gambar_menu" class="mt-2" />
              </div>
              <div class="flex items-center">
                <input id="favorit" type="checkbox" v-model="form.favorit" :checked="form.favorit" class="rounded border-gray-300 text-gray-700 shadow-sm focus:ring-gray-800" />
                <label for="favorit" class="ml-2 block text-sm text-gray-900">Jadikan Menu Favorit</label>
              </div>
            </div>
            <div class="flex justify-end gap-4 pt-6 mt-6 border-t">
              <button type="button" @click="closeModal" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg text-sm">Batal</button>
              <button type="submit" :disabled="form.processing" class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg text-sm transition-colors" :class="{ 'opacity-50 cursor-not-allowed': form.processing }">
                {{ form.processing ? 'Menyimpan...' : 'Simpan Menu' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

    <Teleport to="body">
      <div
        v-if="showEventModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="closeEventModal"
      >
        <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center rounded-t-lg">
            <h3 class="text-xl font-bold">{{ isEditingEvent ? 'Edit Event' : 'Tambah Event Baru' }}</h3>
            <button @click="closeEventModal" class="text-white hover:text-gray-300 text-2xl leading-none">×</button>
          </div>
          
          <form @submit.prevent="submitEvent" class="p-6">
            <div class="space-y-4">
              
              <div>
                <InputLabel for="nama_event" value="Nama Event" />
                <TextInput id="nama_event" v-model="formEvent.nama_event" type="text" class="mt-1 block w-full" required />
                <InputError :message="formEvent.errors.nama_event" class="mt-2" />
              </div>

              <div>
                <InputLabel for="deskripsi_event" value="Deskripsi" />
                <textarea id="deskripsi_event" v-model="formEvent.deskripsi_event" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                <InputError :message="formEvent.errors.deskripsi_event" class="mt-2" />
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <InputLabel for="tanggal" value="Tanggal Event" /> 
                  <TextInput id="tanggal" v-model="formEvent.tanggal" type="date" class="mt-1 block w-full" required />
                  <InputError :message="formEvent.errors.tanggal" class="mt-2" />
                </div>
                <div>
                  <InputLabel for="waktu" value="Waktu Event" />
                  <TextInput id="waktu" v-model="formEvent.waktu" type="time" class="mt-1 block w-full" required />
                  <InputError :message="formEvent.errors.waktu" class="mt-2" />
                </div>
              </div>

              <div>
                <InputLabel for="gambar_event" value="Gambar Event" />
                <input id="gambar_event" type="file" @input="formEvent.gambar_event = $event.target.files[0]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                <progress v-if="formEvent.progress" :value="formEvent.progress.percentage" max="100" class="w-full mt-2">{{ formEvent.progress.percentage }}%</progress>
                <div v-if="isEditingEvent && formEvent.gambar_url" class="mt-2">
                  <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                  <img :src="formEvent.gambar_url" :alt="formEvent.nama_event" class="w-40 h-auto object-cover rounded shadow" />
                </div>
                <InputError :message="formEvent.errors.gambar_event" class="mt-2" />
              </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 mt-6 border-t">
              <button type="button" @click="closeEventModal" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg text-sm">Batal</button>
              <button type="submit" :disabled="formEvent.processing" class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2.5 rounded-lg text-sm transition-colors" :class="{ 'opacity-50 cursor-not-allowed': formEvent.processing }">
                {{ formEvent.processing ? 'Menyimpan...' : 'Simpan Event' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MenuTable from '@/Components/Admin/MenuTable.vue';
import EventTable from '@/Components/Admin/EventTable.vue'; 
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  menus: { type: Array, required: true },
  stats: { type: Object, required: true },
  events: { type: Array, required: true },
  currentTab: { type: String, default: 'menu' }
});

const page = usePage();

const activeTab = computed(() => {
  if (props.currentTab) { return props.currentTab; }
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  return tabParam || 'menu';
});

const initials = computed(() => {
  const admin = page.props.auth?.admin;
  if (!admin || !admin.name) return 'A';
  return admin.name.split(' ').map(word => word[0]).join('').toUpperCase().substring(0, 2);
});

// === LOGIKA MODAL MENU (Sudah Benar) ===
const showAddMenuModal = ref(false);
const isEditing = ref(false);
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
const openAddModal = () => {
  isEditing.value = false;
  form.reset();
  form.kategori = 'makanan';
  showAddMenuModal.value = true;
};
const openEditModal = (menu) => {
  isEditing.value = true;
  form.id_menu = menu.id_menu;
  form.nama_menu = menu.nama_menu;
  form.deskripsi_menu = menu.deskripsi_menu;
  form.harga_menu = menu.harga_menu;
  form.kategori = menu.kategori;
  form.favorit = menu.favorit;
  form.gambar_menu = null;
  form.gambar_url = menu.gambar_url;
  showAddMenuModal.value = true;
};
const closeModal = () => {
  showAddMenuModal.value = false;
  form.reset();
  form.clearErrors();
};
const submitMenu = () => {
  if (isEditing.value) {
    form.put(route('admin.menu.update', form.id_menu), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  } else {
    form.post(route('admin.menu.store'), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  }
};

// ==================================
// === LOGIKA MODAL EVENT (PERBAIKAN) ===
// ==================================
const showEventModal = ref(false);
const isEditingEvent = ref(false);

// Ganti nama field agar sesuai dengan database
const formEvent = useForm({
  id_event: null,
  nama_event: '',
  deskripsi_event: '',
  tanggal: '', // <-- PERBAIKAN
  waktu: '',   // <-- PERBAIKAN
  gambar_event: null,
  gambar_url: null,
});

const openAddEventModal = () => {
  isEditingEvent.value = false;
  formEvent.reset();
  showEventModal.value = true;
};

const openEditEventModal = (event) => {
  isEditingEvent.value = true;
  formEvent.id_event = event.id_event;
  formEvent.nama_event = event.nama_event;
  formEvent.deskripsi_event = event.deskripsi_event;
  formEvent.tanggal = event.tanggal; // <-- PERBAIKAN
  formEvent.waktu = event.waktu;   // <-- PERBAIKAN
  formEvent.gambar_event = null; 
  formEvent.gambar_url = event.gambar_url;
  showEventModal.value = true;
};

const closeEventModal = () => {
  showEventModal.value = false;
  formEvent.reset();
  formEvent.clearErrors();
};

const submitEvent = () => {
  if (isEditingEvent.value) {
    formEvent.put(route('admin.event.update', formEvent.id_event), {
      preserveScroll: true,
      onSuccess: () => closeEventModal(),
    });
  } else {
    formEvent.post(route('admin.event.store'), {
      preserveScroll: true,
      onSuccess: () => closeEventModal(),
    });
  }
};

onMounted(() => {
  console.log('Current active tab:', activeTab.value);
});
</script>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar { width: 8px; }
.overflow-y-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
.overflow-y-auto::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
.overflow-y-auto::-webkit-scrollbar-thumb:hover { background: #555; }
</style>