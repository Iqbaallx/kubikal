<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MenuDetailModal from '@/Components/MenuDetailModal.vue';

// Menerima props 'menus' dari controller Laravel
const props = defineProps({
    menus: Object,
    canLogin: Boolean,
    canRegister: Boolean,
});

const activeTab = ref('makanan'); // 'makanan' atau 'minuman'
const activeSubTab = ref('kopi'); // 'kopi' atau 'non-kopi' (hanya untuk minuman)

const showMenuModal = ref(false);
const selectedMenu = ref(null);

// Filter menu berdasarkan tab aktif
const displayedMenus = computed(() => {
    if (activeTab.value === 'makanan') {
        return props.menus.makanan || [];
    } else {
        // Filter lagi berdasarkan sub-tab minuman
        const minuman = props.menus.minuman || [];
        if (activeSubTab.value === 'kopi') {
            return minuman.filter(menu => menu.tags.includes('Kopi'));
        } else {
            return minuman.filter(menu => menu.tags.includes('Non-Kopi'));
        }
    }
});

const openMenuModal = (menuData) => {
    selectedMenu.value = menuData;
    showMenuModal.value = true;
};

const closeMenuModal = () => {
    showMenuModal.value = false;
    selectedMenu.value = null;
};

// Fungsi untuk mengganti tab utama
const setActiveTab = (tabName) => {
    activeTab.value = tabName;
    // Jika pindah ke tab minuman, default ke sub-tab 'kopi'
    if (tabName === 'minuman') {
        activeSubTab.value = 'kopi';
    }
};

// Fungsi untuk mengganti sub-tab minuman
const setActiveSubTab = (subTabName) => {
    activeSubTab.value = subTabName;
};
</script>

<template>
    <Head title="Menu" />

    <div class="bg-white text-gray-900 min-h-screen flex flex-col">
        <header class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-200">
            <nav class="container mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
                <!-- Logo di kiri -->
                <Link href="/" class="flex items-center space-x-3">
                    <!-- Logo Image - ganti src dengan path logo kamu -->
                    <img 
                        src="/images/logo.png" 
                        alt="Kubikal Space Logo" 
                        class="h-12 w-auto object-contain"
                        @error="handleImageError"
                    >
                    <span class="font-semibold text-xl">Kubikal Space</span>
                </Link>

                <!-- Menu navigasi di tengah -->
                <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-10">
                    <Link href="/" class="text-gray-600 hover:text-gray-900 transition">Home</Link>
                    <Link href="#our-story" class="text-gray-600 hover:text-gray-900 transition">Our Story</Link>
                    <Link href="#events" class="text-gray-600 hover:text-gray-900 transition">Event</Link>
                    <Link :href="route('menu.index')" class="text-gray-900 font-semibold">Menu</Link>
                </div>

                <!-- Auth menu di kanan -->
                <div class="hidden md:flex items-center space-x-4">
                    <template v-if="!$page.props.auth.user">
                        <Link v-if="canLogin" :href="route('login')" class="text-sm text-gray-600 hover:text-gray-900">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" class="text-sm text-gray-600 hover:text-gray-900">Register</Link>
                    </template>
                     <template v-else>
                         <Link :href="route('dashboard')" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</Link>
                     </template>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <!-- Tambahkan tombol hamburger di sini jika perlu -->
                </div>
            </nav>
        </header>

        <main class="pt-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h1 class="text-4xl font-bold text-center mb-10">Menu</h1>

                <div class="flex justify-center mb-8 border-b border-gray-300 dark:border-gray-700">
                    <button
                        @click="setActiveTab('makanan')"
                        :class="[
                            'py-2 px-6 text-lg font-medium transition duration-150 ease-in-out',
                            activeTab === 'makanan'
                                ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 border-b-2 border-transparent'
                        ]"
                    >
                        Makanan
                    </button>
                    <button
                        @click="setActiveTab('minuman')"
                        :class="[
                            'py-2 px-6 text-lg font-medium transition duration-150 ease-in-out',
                            activeTab === 'minuman'
                                ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400'
                                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 border-b-2 border-transparent'
                        ]"
                    >
                        Minuman
                    </button>
                </div>

                 <div v-if="activeTab === 'minuman'" class="flex justify-center mb-8 space-x-4">
                    <button
                        @click="setActiveSubTab('kopi')"
                        :class="[
                            'py-1 px-4 text-sm rounded-md transition duration-150 ease-in-out',
                            activeSubTab === 'kopi'
                                ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300'
                                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'
                        ]"
                    >
                        Kopi
                    </button>
                    <button
                        @click="setActiveSubTab('non-kopi')"
                         :class="[
                            'py-1 px-4 text-sm rounded-md transition duration-150 ease-in-out',
                            activeSubTab === 'non-kopi'
                                ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300'
                                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'
                        ]"
                    >
                        Non-Kopi
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 md:gap-8">
                    <div
                        v-for="menu in displayedMenus"
                        :key="menu.id"
                        @click="openMenuModal(menu)"
                        class="menu-item bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:-translate-y-2 cursor-pointer"
                    >
                        <img
                            :src="menu.image || '/images/placeholder.jpg'"
                            :alt="menu.name"
                            class="w-full h-40 object-cover bg-gray-300 dark:bg-gray-600"
                            loading="lazy"
                        >
                        <div class="p-4">
                            <h4 class="font-semibold text-base truncate">{{ menu.name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ menu.price }}</p>
                        </div>
                    </div>
                     <div v-if="displayedMenus.length === 0" class="col-span-full text-center text-gray-500 py-8">
                         Menu belum tersedia.
                     </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-800 dark:bg-black text-gray-400 dark:text-gray-500 py-8 px-4 text-center mt-auto">
            <div class="mb-4">
                <a href="#" class="inline-block mx-2 hover:text-white dark:hover:text-gray-300">FB</a>
                <a href="#" class="inline-block mx-2 hover:text-white dark:hover:text-gray-300">IG</a>
                <a href="#" class="inline-block mx-2 hover:text-white dark:hover:text-gray-300">TW</a>
            </div>
            <p class="text-sm">&copy; {{ new Date().getFullYear() }} Kubikal Space. All rights reserved.</p>
        </footer>
    </div>

    <MenuDetailModal :show="showMenuModal" :menu="selectedMenu" @close="closeMenuModal" />
</template>

<style scoped>
/* Style tambahan jika diperlukan */
.menu-item img {
    aspect-ratio: 1 / 1; /* Membuat gambar tetap persegi */
}
</style>