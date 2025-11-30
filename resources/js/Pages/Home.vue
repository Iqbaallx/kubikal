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

// Gallery images - Max 4 images
const galleryImages = ref([
    '/images/About.png',
    '/images/art.jpg', 
    '/images/mie.jpg',
    '/images/nasgor.jpg'
])

const currentSlideIndex = ref(0) 
const isLightboxOpen = ref(false)

const currentMainImage = computed(() => galleryImages.value[currentSlideIndex.value])

const nextSlide = () => {
    currentSlideIndex.value = (currentSlideIndex.value + 1) % galleryImages.value.length
}

const prevSlide = () => {
    currentSlideIndex.value = (currentSlideIndex.value - 1 + galleryImages.value.length) % galleryImages.value.length
}

const openLightboxWithImage = (imgSrc) => {
    const index = galleryImages.value.indexOf(imgSrc);
    if (index !== -1) {
        currentSlideIndex.value = index;
        openLightbox();
    }
}

const openLightbox = () => {
    isLightboxOpen.value = true
}

const closeLightbox = () => {
    isLightboxOpen.value = false
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

    document.querySelectorAll('.scroll-animate').forEach((el) => {
        observer.observe(el)
    })
}

onMounted(() => {
    setupScrollAnimation()
})

onUnmounted(() => {
    if (observer) {
        observer.disconnect()
    }
})
</script>

<template>
    <Head title="Home" />

    <div class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main class="flex-1">
            <!-- Hero Section -->
            <section class="relative h-[70vh] md:h-[85vh] lg:h-screen min-h-[600px] bg-cover bg-center" style="background-image: url('/images/HeroSelection.png');">
                <div class="absolute inset-0 bg-black/30"></div>
                <div class="relative h-full flex items-center justify-center text-center text-white px-4">
                    <div class="scroll-animate fade-up max-w-3xl">
                        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-3 md:mb-4">
                            Crafted Coffee & Delicious Bites
                        </h1>
                        <p class="text-sm md:text-base lg:text-lg mb-6 md:mb-8 max-w-2xl mx-auto">
                            Experience the perfect blend of coffee and delightful food in cozy atmosphere.
                        </p>
                        <a href="#gallery"
                           class="inline-block bg-white text-gray-800 py-2.5 px-6 md:py-3 md:px-8 rounded font-semibold hover:bg-gray-100 transition-all duration-300 text-sm md:text-base">
                            Gallery
                        </a>
                    </div>
                </div>
            </section>

            <!-- Gallery Section -->
            <section id="gallery" class="py-12 md:py-16 px-4 bg-gray-50 dark:bg-gray-800">
                <div class="container mx-auto max-w-6xl">
                    <div class="text-center mb-8 md:mb-12">
                        <h2 class="text-2xl md:text-3xl font-bold mb-3 scroll-animate fade-up">Gallery</h2>
                        <p class="text-gray-600 dark:text-gray-400 scroll-animate fade-up text-sm md:text-base">
                            Take a peek into our world of handcrafted coffee and delicious bites that await you.
                        </p>
                    </div>
                    
                    <!-- Gallery Grid - 4 columns -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                        <div 
                            v-for="(imgSrc, index) in galleryImages" 
                            :key="'gallery-img-' + index" 
                            class="gallery-item rounded-lg overflow-hidden shadow-md hover:shadow-xl transform transition-all duration-300 hover:scale-105 cursor-pointer scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                            @click="openLightboxWithImage(imgSrc)"
                        >
                            <div class="aspect-square bg-gray-200 dark:bg-gray-700">
                                <img 
                                    :src="imgSrc" 
                                    class="w-full h-full object-cover"
                                    :alt="'Gallery Image ' + (index + 1)"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Story Section -->
            <section id="our-story" class="py-12 md:py-16 px-4 bg-white dark:bg-gray-900">
                <div class="container mx-auto max-w-6xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                        <div class="scroll-animate slide-left order-2 md:order-1">
                            <div class="rounded-lg overflow-hidden shadow-lg">
                                <img src="/images/About.png" alt="Our Story"
                                     class="w-full h-[300px] md:h-[400px] object-cover">
                            </div>
                        </div>
                        <div class="scroll-animate slide-right order-1 md:order-2">
                            <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6">Our Story</h2>
                            <div class="space-y-3 md:space-y-4 text-gray-700 dark:text-gray-300 text-sm md:text-base">
                                <p class="leading-relaxed">
                                    Selarang saring karna ingah batti ungus kertis.
                                </p>
                                <p class="leading-relaxed">
                                    Kopi kami berasal dari biji pilihan yang diangkat dari tingkat oleh para pengusaha pilihan
                                    rafah iklimis linggang dan pingkal lampiran.
                                </p>
                                <p class="leading-relaxed">
                                    Ingin panigas dengan Mangan karena keretis - them titech mengkahion pogamilinan
                                    ragah ulitimis fange - ater aping haramtah pilises satung harken.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Info Section -->
            <section class="py-12 md:py-16 px-4 bg-gray-50 dark:bg-gray-800">
                <div class="container mx-auto max-w-5xl">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                        <!-- Jam Buka -->
                        <div class="scroll-animate zoom-in text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-800 dark:bg-gray-600 mb-4">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-bold mb-2">Jam Buka & Tutup</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base">Setiap Minggu: 08:00 - 23:00</p>
                        </div>
                        
                        <!-- Lokasi -->
                        <div class="scroll-animate zoom-in text-center" style="animation-delay: 0.1s;">
                            <div class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 rounded-full bg-gray-800 dark:bg-gray-600 mb-4">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg md:text-xl font-bold mb-2">Lokasi</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base mb-1">
                                Jl. Mariobro No. 123, Kota Rangkep,
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm md:text-base mb-4">Indonesia</p>
                            <a href="https://maps.app.goo.gl/DvWZQJ2hJmx9Z3dR8"
                               target="_blank"
                               class="inline-block px-5 py-2 bg-gray-800 text-white text-sm rounded hover:bg-gray-700 transition">
                                Lihat di Peta
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Upcoming Events -->
            <section id="events" class="py-12 md:py-16 px-4 bg-white dark:bg-gray-900">
                <div class="container mx-auto max-w-6xl">
                    <div class="text-center mb-8 md:mb-12">
                        <h2 class="text-2xl md:text-3xl font-bold mb-3 scroll-animate fade-up">Upcoming Events</h2>
                        <p class="text-gray-600 dark:text-gray-400 scroll-animate fade-up text-sm md:text-base">
                            Join us for special moments and great coffee.
                        </p>
                    </div>
                    
                    <div v-if="events && events.length > 0" class="flex flex-wrap justify-center gap-6 md:gap-8">
                        <div
                            v-for="(event, index) in events.slice(0, 3)" 
                            :key="event.id_event"
                            @click="openEventModal(event)"
                            class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-xl transform transition-all duration-300 hover:-translate-y-1 cursor-pointer scroll-animate scale-in w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-21px)] max-w-sm"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                        >
                            <div class="h-48 overflow-hidden bg-gray-200 dark:bg-gray-700">
                                <img :src="event.gambar_url || '/images/placeholder-event.jpg'" :alt="event.nama_event"
                                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg md:text-xl font-bold mb-2">{{ event.nama_event }}</h3>
                                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-2">{{ event.tanggal_mulai }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ event.deskripsi_event }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada event yang akan datang.</p>
                    </div>
                </div>
            </section>

            <!-- Best Sellers -->
            <section class="py-12 md:py-16 px-4 bg-gray-50 dark:bg-gray-800">
                <div class="container mx-auto max-w-6xl">
                    <div class="text-center mb-8 md:mb-12">
                        <h2 class="text-2xl md:text-3xl font-bold scroll-animate fade-up">Our Best Sellers</h2>
                    </div>
                    
                    <div v-if="favoriteMenus && favoriteMenus.length > 0" class="flex flex-wrap justify-center gap-4 md:gap-6">
                        <div
                            v-for="(menu, index) in favoriteMenus.slice(0, 4)" 
                            :key="menu.id_menu"
                            @click="openMenuModal(menu)"
                            class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-md hover:shadow-xl transform transition-all duration-300 hover:-translate-y-1 cursor-pointer scroll-animate scale-in w-[calc(50%-8px)] sm:w-[calc(33.333%-16px)] lg:w-[calc(25%-18px)] max-w-xs"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                        >
                            <div class="aspect-square overflow-hidden bg-gray-200 dark:bg-gray-600">
                                <img :src="menu.gambar_url || '/images/placeholder.jpg'" :alt="menu.nama_menu" 
                                     class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-sm md:text-base mb-1 text-center">{{ menu.nama_menu }}</h4>
                                <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 text-center line-clamp-2">{{ menu.deskripsi_menu }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada menu favorit yang ditambahkan.</p>
                    </div>

                    <div class="mt-8 md:mt-12 text-center scroll-animate fade-up">
                        <Link :href="route('menu.index')"
                            class="inline-block bg-gray-800 text-white dark:bg-gray-600 py-2.5 px-6 md:py-3 md:px-8 rounded font-semibold hover:bg-gray-700 dark:hover:bg-gray-500 transition duration-300 text-sm md:text-base">
                            View All Menu
                        </Link>
                    </div>
                </div>
            </section>
        </main>

        <AppFooter />
    </div>

    <!-- Lightbox Modal -->
    <Teleport to="body">
        <div 
            v-if="isLightboxOpen" 
            class="fixed inset-0 z-[999] bg-black/95 backdrop-blur-sm flex items-center justify-center p-4"
            @click="closeLightbox"
        >
            <button 
                class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 z-50 w-12 h-12 flex items-center justify-center rounded-full hover:bg-white/10 transition-all"
                @click="closeLightbox"
                aria-label="Close"
            >×</button>

            <button 
                @click.stop="prevSlide"
                class="absolute left-4 text-white p-3 md:p-4 hover:bg-white/20 rounded-full transition-all z-50"
                aria-label="Previous"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 md:w-10 md:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <img 
                :src="currentMainImage" 
                class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl"
                @click.stop
                :alt="'Gallery Image ' + (currentSlideIndex + 1)"
            >

            <button 
                @click.stop="nextSlide"
                class="absolute right-4 text-white p-3 md:p-4 hover:bg-white/20 rounded-full transition-all z-50"
                aria-label="Next"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 md:w-10 md:h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>

            <!-- Image Counter -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/60 text-white px-4 py-2 rounded-full text-sm">
                {{ currentSlideIndex + 1 }} / {{ galleryImages.length }}
            </div>
        </div>
    </Teleport>

    <MenuDetailModal :show="showMenuModal" :item="selectedMenu" @close="closeMenuModal" />
    <EventDetailModal :show="showEventModal" :item="selectedEvent" @close="closeEventModal" />
</template>

<style scoped>
/* Line Clamp Utilities */
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

/* Aspect Ratio */
.aspect-square {
    aspect-ratio: 1 / 1;
}

/* Scroll Animation Base Styles */
.scroll-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-animate.animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Animation Variants */
.fade-up {
    transform: translateY(50px);
}

.fade-up.animate-in {
    transform: translateY(0);
}

.slide-left {
    transform: translateX(-60px);
    opacity: 0;
}

.slide-left.animate-in {
    transform: translateX(0);
    opacity: 1;
}

.slide-right {
    transform: translateX(60px);
    opacity: 0;
}

.slide-right.animate-in {
    transform: translateX(0);
    opacity: 1;
}

.scale-in {
    transform: scale(0.85);
    opacity: 0;
}

.scale-in.animate-in {
    transform: scale(1);
    opacity: 1;
}

.zoom-in {
    transform: scale(0.92);
    opacity: 0;
}

.zoom-in.animate-in {
    transform: scale(1);
    opacity: 1;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Prevent layout shift during animations */
@media (prefers-reduced-motion: reduce) {
    .scroll-animate {
        opacity: 1;
        transform: none;
        transition: none;
    }
}
</style>