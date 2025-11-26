<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'
import MenuDetailModal from '@/Components/MenuDetailModal.vue'
import EventDetailModal from '@/Components/EventDetailModal.vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    events: Array,
    favoriteMenus: Array,
})

const showMenuModal = ref(false)
const selectedMenu = ref(null)
const showEventModal = ref(false)
const selectedEvent = ref(null)

const openMenuModal = (menuData) => {
    selectedMenu.value = menuData
    showMenuModal.value = true
}
const closeMenuModal = () => {
    showMenuModal.value = false
    selectedMenu.value = null
}
const openEventModal = (eventData) => {
    selectedEvent.value = eventData
    showEventModal.value = true
}
const closeEventModal = () => {
    showEventModal.value = false
    selectedEvent.value = null
}

const mainSliderImages = ref([
    '/images/About.png',
    '/images/art.jpg', 
    '/images/mie.jpg'
])

const smallGalleryImages = ref([
    '/images/nasgor.jpg',
    '/images/holi.jpg'
])

const mainGalleryHeight = '625px';
const smallGalleryHeight = '300px';

const currentSlideIndex = ref(0) 
const isLightboxOpen = ref(false)
let autoPlayInterval = null

const currentMainImage = computed(() => mainSliderImages.value[currentSlideIndex.value])

const nextSlide = () => {
    currentSlideIndex.value = (currentSlideIndex.value + 1) % mainSliderImages.value.length
}

const prevSlide = () => {
    currentSlideIndex.value = (currentSlideIndex - 1 + mainSliderImages.value.length) % mainSliderImages.value.length
}

const openLightboxWithImage = (imgSrc) => {
    let index = mainSliderImages.value.indexOf(imgSrc);
    
    if (index === -1) {
        mainSliderImages.value.push(imgSrc);
        index = mainSliderImages.value.length - 1;
    }

    currentSlideIndex.value = index;
    openLightbox();
}

const startAutoPlay = () => {
    stopAutoPlay() 
    autoPlayInterval = setInterval(nextSlide, 5000) 
}

const stopAutoPlay = () => {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval)
        autoPlayInterval = null
    }
}

const openLightbox = () => {
    stopAutoPlay() 
    isLightboxOpen.value = true
}

const closeLightbox = () => {
    isLightboxOpen.value = false
    startAutoPlay() 
}

// Scroll Animation Setup
let observer = null

const setupScrollAnimation = () => {
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in')
                }
            })
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        }
    )

    // Observe all elements with scroll-animate class
    document.querySelectorAll('.scroll-animate').forEach((el) => {
        observer.observe(el)
    })
}

onMounted(() => {
    startAutoPlay()
    setupScrollAnimation()
})

onUnmounted(() => {
    stopAutoPlay()
    if (observer) {
        observer.disconnect()
    }
})
</script>

<template>
    <Head title="Home" />

    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main>
            <section class="relative h-screen bg-cover bg-center" style="background-image: url('/images/HeroSelection.png');">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center text-white">
                    <div class="scroll-animate fade-up">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Crafted Coffee & Delicious Bites</h1>
                        <p class="text-lg md:text-xl mb-8">Selamat datang di Kubikal Space</p>
                        <a href="#gallery"
                           class="bg-white text-gray-800 py-2 px-6 rounded-md font-semibold hover:bg-gray-200 transition duration-300">
                            Lihat Galeri
                        </a>
                    </div>
                </div>
            </section>

            <section id="gallery" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-8 scroll-animate fade-up">Gallery</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                        <div 
                            class="relative col-span-1 lg:col-span-2 rounded-xl overflow-hidden shadow-2xl group scroll-animate slide-left"
                            :style="{ height: mainGalleryHeight }" 
                            @mouseenter="stopAutoPlay"
                            @mouseleave="startAutoPlay"
                        >
                            <img 
                                :src="currentMainImage" 
                                class="w-full h-full object-cover cursor-pointer transition-transform duration-500 ease-in-out"
                                :alt="'Gallery Image ' + (currentSlideIndex + 1)"
                                @click="openLightbox"
                            >

                            <button 
                                @click.stop="prevSlide" 
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button 
                                @click.stop="nextSlide" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/60 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-1 flex flex-col gap-6 pr-2 scroll-animate slide-right">
                            <div 
                                v-for="(imgSrc, index) in smallGalleryImages" 
                                :key="'small-img-' + index" 
                                class="rounded-xl overflow-hidden shadow-lg transform transition duration-200 hover:opacity-90 hover:shadow-xl cursor-pointer"
                                :style="{ height: smallGalleryHeight }" 
                                @click="openLightboxWithImage(imgSrc)"
                            >
                                <img 
                                    :src="imgSrc" 
                                    class="w-full h-full object-cover"
                                    :alt="'Small Gallery Image ' + (index + 1)"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="our-story" class="py-16 px-4 md:px-8 lg:px-16 bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="w-full md:w-1/2 scroll-animate slide-left">
                        <img src="/images/About.png" alt="Our Story"
                             class="rounded-lg shadow-lg w-full h-64 md:h-80 object-cover bg-gray-300 dark:bg-gray-700">
                    </div>
                    <div class="w-full md:w-1/2 text-center md:text-left scroll-animate slide-right">
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
                    <div class="scroll-animate zoom-in">
                        <div class="flex items-center justify-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <h3 class="text-xl font-semibold">Jam Buka & Tutup</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Setiap Hari: 08:00 - 22:00</p>
                    </div>
                    <div class="scroll-animate zoom-in" style="animation-delay: 0.1s;">
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

            <section id="events" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-8 scroll-animate fade-up">Upcoming Events</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            v-for="(event, index) in events" 
                            :key="event.id_event"
                            @click="openEventModal(event)"
                            class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2 cursor-pointer scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                        >
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

            <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold mb-12 text-center scroll-animate fade-up">Our Best Sellers</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                        <div
                            v-for="(menu, index) in favoriteMenus" 
                            :key="menu.id_menu"
                            @click="openMenuModal(menu)"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                        >
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

                    <div class="mt-10 flex justify-end scroll-animate fade-up">
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

    <Teleport to="body">
        <div 
            v-if="isLightboxOpen" 
            class="fixed inset-0 z-[999] bg-black bg-opacity-95 flex items-center justify-center p-4"
            @click="closeLightbox"
        >
            <button 
                class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 z-50"
                @click="closeLightbox"
            >×</button>

            <button 
                @click.stop="prevSlide"
                class="absolute left-4 text-white p-4 hover:bg-white/10 rounded-full transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <img 
                :src="currentMainImage" 
                class="max-w-full max-h-[90vh] object-contain rounded shadow-2xl"
                @click.stop
            >

            <button 
                @click.stop="nextSlide"
                class="absolute right-4 text-white p-4 hover:bg-white/10 rounded-full transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </Teleport>

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

/* Scroll Animation Styles */
.scroll-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-animate.animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Fade Up */
.fade-up {
    transform: translateY(40px);
}

.fade-up.animate-in {
    transform: translateY(0);
}

/* Slide Left */
.slide-left {
    transform: translateX(-50px);
    opacity: 0;
}

.slide-left.animate-in {
    transform: translateX(0);
    opacity: 1;
}

/* Slide Right */
.slide-right {
    transform: translateX(50px);
    opacity: 0;
}

.slide-right.animate-in {
    transform: translateX(0);
    opacity: 1;
}

/* Scale In */
.scale-in {
    transform: scale(0.8);
    opacity: 0;
}

.scale-in.animate-in {
    transform: scale(1);
    opacity: 1;
}

/* Zoom In */
.zoom-in {
    transform: scale(0.9);
    opacity: 0;
}

.zoom-in.animate-in {
    transform: scale(1);
    opacity: 1;
}
</style>