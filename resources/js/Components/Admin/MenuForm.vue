<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'; // <-- Pastikan ini ada
import TextInput from '@/Components/TextInput.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    menu: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

// Gunakan useForm dari Inertia
const form = useForm({
    _method: props.menu ? 'PUT' : 'POST',
    nama: props.menu?.nama || '',
    harga: props.menu?.harga || 0,
    kategori: props.menu?.kategori || 'Minuman',
    deskripsi: props.menu?.deskripsi || '',
    is_favorit: props.menu?.is_favorit || false,
    foto: null, // Input file akan ditangani secara terpisah
});

// URL pratinjau untuk gambar
const fotoPreview = ref(props.menu?.image_url || null);

// Fungsi untuk menangani update file
const onFotoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.foto = file;
        // Buat URL sementara untuk pratinjau
        fotoPreview.value = URL.createObjectURL(file);
    }
};

// Fungsi untuk submit form
const submit = () => {
    const url = props.menu
        ? route('admin.menu.update', props.menu.id)
        : route('admin.menu.store');

    form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
            emit('close'); // Tutup modal setelah sukses
            form.reset();
            fotoPreview.value = null;
        },
        onError: (errors) => {
            console.error(errors);
        },
        // Paksa Inertia untuk mengirim sebagai multipart/form-data
        forceFormData: true, 
    });
};

// Reset form jika prop 'menu' berubah (misal: dari edit ke create)
watch(() => props.menu, (newMenu) => {
    form._method = newMenu ? 'PUT' : 'POST';
    form.nama = newMenu?.nama || '';
    form.harga = newMenu?.harga || 0;
    form.kategori = newMenu?.kategori || 'Minuman';
    form.deskripsi = newMenu?.deskripsi || '';
    form.is_favorit = newMenu?.is_favorit || false;
    form.foto = null;
    fotoPreview.value = newMenu?.image_url || null;
    form.clearErrors();
});

</script>

<template>
    <form @submit.prevent="submit" class="p-6 space-y-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ menu ? 'Edit Menu' : 'Tambah Menu Baru' }}
        </h2>

        <div>
            <InputLabel for="nama" value="Nama Menu" />
            <TextInput
                id="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                required
                autofocus
            />
            <InputError class="mt-2" :message="form.errors.nama" />
        </div>

        <div>
            <InputLabel for="harga" value="Harga" />
            <TextInput
                id="harga"
                type="number"
                class="mt-1 block w-full"
                v-model="form.harga"
                required
            />
            <InputError class="mt-2" :message="form.errors.harga" />
        </div>

        <div>
            <InputLabel for="kategori" value="Kategori" />
            <select
                id="kategori"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="form.kategori"
            >
                <option value="Minuman">Minuman</option>
                <option value="Makanan">Makanan</option>
            </select>
            <InputError class="mt-2" :message="form.errors.kategori" />
        </div>

        <div>
            <InputLabel for="deskripsi" value="Deskripsi" />
            <textarea
                id="deskripsi"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                v-model="form.deskripsi"
                rows="3"
            ></textarea>
            <InputError class="mt-2" :message="form.errors.deskripsi" />
        </div>

        <div class="flex items-center gap-4">
            <InputLabel for="is_favorit" value="Jadikan Favorit?" />
            <input
                id="is_favorit"
                type="checkbox"
                class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                v-model="form.is_favorit"
                :checked="form.is_favorit"
            />
            <InputError class="mt-2" :message="form.errors.is_favorit" />
        </div>

        <div>
            <InputLabel for="foto" value="Foto Menu" />
            <input
                id="foto"
                type="file"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-800"
                @change="onFotoChange"
                accept="image/*"
            />
            <InputError class="mt-2" :message="form.errors.foto" />
        </div>

        <div v-if="fotoPreview" class="mt-4">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Pratinjau:</p>
            <img :src="fotoPreview" alt="Pratinjau Foto" class="mt-2 h-32 w-32 object-cover rounded-md" />
        </div>


        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">
                {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
            </PrimaryButton>

            <SecondaryButton type="button" @click="emit('close')">
                Batal
            </SecondaryButton>
        </div>
    </form>
</template>