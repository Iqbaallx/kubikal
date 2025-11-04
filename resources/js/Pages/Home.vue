<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import MenuDetailModal from '@/Components/MenuDetailModal.vue'
import EventDetailModal from '@/Components/EventDetailModal.vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

// Props dari Laravel (controller)
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    events: Array,
    favoriteMenus: Array,
})

// State modal Menu
const showMenuModal = ref(false)
const selectedMenu = ref(null)

// State modal Event
const showEventModal = ref(false)
const selectedEvent = ref(null)

// Fungsi modal Menu
const openMenuModal = (menuData) => {
    selectedMenu.value = menuData
    showMenuModal.value = true
}
const closeMenuModal = () => {
    showMenuModal.value = false
    selectedMenu.value = null
}

// Fungsi modal Event
const openEventModal = (eventData) => {
    selectedEvent.value = eventData
    showEventModal.value = true
}
const closeEventModal = () => {
    showEventModal.value = false
    selectedEvent.value = null
}
</script>

<template>
    <Head title="Home" />

    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main>
            <!-- Hero Section -->
            <section class="relative h-screen bg-cover bg-center" style="background-image: url('/images/HeroSelection.png');">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center text-white">
                    <div>
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Crafted Coffee & Delicious Bites</h1>
                        <p class="text-lg md:text-xl mb-8">Selamat datang di Kubikal Space</p>
                        <a href="#our-story"
                           class="bg-white text-gray-800 py-2 px-6 rounded-md font-semibold hover:bg-gray-200 transition duration-300">
                           Learn More
                        </a>
                    </div>
                </div>
            </section>

            <!-- Our Story -->
            <section id="our-story" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="w-full md:w-1/2">
                        <img src="/images/About.png" alt="Our Story"
                             class="rounded-lg shadow-lg w-full h-64 md:h-80 object-cover bg-gray-300 dark:bg-gray-700">
                    </div>
                    <div class="w-full md:w-1/2 text-center md:text-left">
                        <h2 class="text-3xl font-bold mb-4">Our Story</h2>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Kami percaya, setiap cangkir kopi punya cerita.
                            Kopi kami berasal dari biji pilihan Makassar, dikenal dengan aroma yang khas dan rasa 
                            yang berani — hasil bumi yang dirawat dengan cinta oleh petani lokal.
                            <br><br>
                            Dari proses sangrai hingga seduhan terakhir, kami ingin menghadirkan pengalaman ngopi 
                            yang otentik, hangat, dan penuh karakter.
                            Inilah cita rasa Makassar, dalam setiap tegukan.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Info -->
            <section class="py-12 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                    <div>
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="text-xl font-semibold">Jam Buka & Tutup</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Setiap Hari: 08:00 - 22:00</p>
                    </div>
                    <div>
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <h3 class="text-xl font-semibold">Lokasi</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">
                            Jl. Surya I No.1, Jebres, Kota Surakarta, Jawa Tengah 57126
                        </p>
                        <a href="https://maps.app.goo.gl/DvWZQJ2hJmx9Z3dR8"
                           class="mt-2 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                           Lihat Peta
                        </a>
                    </div>
                </div>
            </section>

            <!-- Upcoming Events -->
            <section id="events" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-8">Upcoming Events</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            v-for="event in events" :key="event.id_event"
                            @click="openEventModal(event)"
                            class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                            <img :src="event.gambar_url || '/images/placeholder-event.jpg'" :alt="event.nama_event"
                                class="rounded-md mb-4 w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                            <h3 class="text-xl font-semibold mb-2">{{ event.nama_event }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ event.deskripsi_event }}</p>
                        </div>

                        <div v-if="!events || events.length === 0" class="col-span-full text-gray-500 py-8">
                            Belum ada event yang akan datang.
                        </div>
                    </div>
                </div>
            </section>

            <!-- Best Sellers -->
            <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold mb-12 text-center">Our Best Sellers</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                        <div
                            v-for="menu in favoriteMenus" :key="menu.id_menu"
                            @click="openMenuModal(menu)"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="aspect-square overflow-hidden">
                                <img :src="menu.gambar_url || '/images/placeholder.jpg'" :alt="menu.nama_menu" class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1 truncate">{{ menu.nama_menu }}</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ menu.deskripsi_menu }}</p>
                            </div>
                        </div>

                        <div v-if="!favoriteMenus || favoriteMenus.length === 0" class="col-span-full text-gray-500 py-8">
                            Belum ada menu favorit yang ditambahkan.
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end">
                        <Link :href="route('menu.index')"
                            class="bg-gray-800 text-white dark:bg-gray-600 dark:text-gray-200 py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 dark:hover:bg-gray-500 transition duration-300 shadow-md">
                            more menu
                        </Link>
                    </div>
                </div>
            </section>
        </main>

        <AppFooter class="mt-auto" />
    </div>

    <!-- Modals -->
    <MenuDetailModal :show="showMenuModal" :item="selectedMenu" @close="closeMenuModal" />
    <EventDetailModal :show="showEventModal" :item="selectedEvent" @close="closeEventModal" />
</template>

<style scoped>
.h-screen { height: 100vh; }
.event-card img { aspect-ratio: 16 / 9; }
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}
</style>
