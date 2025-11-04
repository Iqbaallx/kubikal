<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import MenuDetailModal from '@/Components/MenuDetailModal.vue';
import EventDetailModal from '@/Components/EventDetailModal.vue'; // <-- DITAMBAHKAN: Import modal event
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// State untuk modal menu
const showMenuModal = ref(false);
const selectedMenu = ref(null);

// <-- DITAMBAHKAN: State untuk modal event -->
const showEventModal = ref(false);
const selectedEvent = ref(null);

// Fungsi untuk membuka modal menu
const openMenuModal = (menuData) => {
    selectedMenu.value = menuData;
    showMenuModal.value = true;
};

// Fungsi untuk menutup modal menu
const closeMenuModal = () => {
    showMenuModal.value = false;
    selectedMenu.value = null;
};

// <-- DITAMBAHKAN: Fungsi untuk modal event -->
const openEventModal = (eventData) => {
    selectedEvent.value = eventData;
    showEventModal.value = true;
};

const closeEventModal = () => {
    showEventModal.value = false;
    selectedEvent.value = null;
};

// <-- DITAMBAHKAN: Data event (contoh) -->
// Nantinya, data ini sebaiknya dikirim dari Controller Laravel sebagai props
const events = ref([
    {
        name: 'Live Acoustic Night',
        date: '2024-07-12',
        description: 'Setiap Jumat malam, nikmati alunan musik akustik santai sambil menikmati kopi favoritmu.',
        image: '/images/live.jpg'
    },
    {
        name: 'Latte Art Workshop',
        date: '2024-07-20',
        description: 'Pelajari seni membuat latte art yang indah bersama barista kami. Terbatas!',
        image: '/images/art.jpg'
    },
    {
        name: 'Holiday Specials Tasting',
        date: '2024-12-15',
        description: 'Cicipi menu spesial liburan kami yang baru, mulai dari minuman hingga makanan penutup.',
        image: '/images/holi.jpg'
    }
]);
</script>

<template>
    <Head title="Home" />

    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">

        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main>
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

            <section class="py-12 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                    <div>
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold">Jam Buka & Tutup</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Setiap Hari: 08:00 - 22:00</p>
                    </div>
                    <div>
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold">Lokasi</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Jl. Surya I No.1, Jebres, Kec. Jebres, Kota Surakarta, Jawa Tengah 57126</p>
                        <a href="https://www.google.com/maps/@-7.5542516,110.855285,3a,75y,201.25h,40.21t/data=!3m7!1e1!3m5!1sPfOHgCHtquv_pJAP3XRBRw!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D49.7924544664621%26panoid%3DPfOHgCHtquv_pJAP3XRBRw%26yaw%3D201.2471147394687!7i16384!8i8192?entry=ttu&g_ep=EgoyMDI1MTAyNi4wIKXMDSoASAFQAw%3D%3D" class="mt-2 inline-block text-blue-600 dark:text-blue-400 hover:underline">Lihat Peta</a>
                    </div>
                </div>
            </section>

            <section id="events" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-8">Upcoming Events</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            v-for="(event, index) in events" :key="index"
                            @click="openEventModal(event)"
                            class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                            <img :src="event.image" :alt="event.name"
                                class="rounded-md mb-4 w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                            <h3 class="text-xl font-semibold mb-2">{{ event.name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ event.description }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold mb-12 text-center">Our Best Sellers</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                        
                        <div
                            @click="openMenuModal({ name: 'Cappuccino', price: 'Rp 25.000', description: 'Kopi susu klasik dengan foam lembut dan taburan cokelat di atasnya. Menggunakan espresso berkualitas tinggi dipadu dengan susu segar.', image: '/images/menu-cappuccino.jpg' })"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="aspect-square overflow-hidden">
                                <img src="/images/capucino.jpg" alt="Cappuccino" class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1">Cappuccino</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">Classic espresso with steamed milk and a foamy top</p>
                            </div>
                        </div>
                        
                        <div
                            @click="openMenuModal({ name: 'Latte', price: 'Rp 25.000', description: 'Perpaduan espresso dan susu steamed dengan sedikit lapisan foam di atasnya.', image: '/images/menu-latte.jpg' })"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="aspect-square overflow-hidden">
                                <img src="/images/latte.jpg" alt="Latte" class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1">Latte</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">Espresso with steamed milk and a thin layer of foam</p>
                            </div>
                        </div>

                        <div
                            @click="openMenuModal({ name: 'Espresso', price: 'Rp 20.000', description: 'Ekstraksi kopi murni dengan crema tebal, dasar dari banyak minuman kopi.', image: '/images/menu-espresso.jpg' })"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="aspect-square overflow-hidden">
                                <img src="/images/expres.jpg" alt="Espresso" class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1">Espresso</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">Strong, concentrated coffee served in a small cup</p>
                            </div>
                        </div>

                        <div
                            @click="openMenuModal({ name: 'Cold Brew', price: 'Rp 30.000', description: 'Kopi yang diseduh dengan air dingin selama berjam-jam, menghasilkan rasa yang halus dan rendah asam.', image: '/images/menu-cold-brew.jpg' })"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="aspect-square overflow-hidden">
                                <img src="/images/cold.jpg" alt="Cold Brew" class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1">Cold Brew</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">Smooth, low-acid coffee steeped for 12-24 hours</p>
                            </div>
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

    <MenuDetailModal :show="showMenuModal" :menu="selectedMenu" @close="closeMenuModal" />

    <EventDetailModal :show="showEventModal" :event="selectedEvent" @close="closeEventModal" />
</template>

<style scoped>
.h-screen {
    height: 100vh;
}

.menu-item img {
    aspect-ratio: 1 / 1;
}

/* DITAMBAHKAN: Style untuk card event */
.event-card img {
    aspect-ratio: 16 / 9; /* Menyesuaikan rasio gambar event */
}

/* DITAMBAHKAN: Class untuk membatasi teks deskripsi */
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}
</style>