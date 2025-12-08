<template>
    <Head title="Home" />

    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main>
            <!-- HERO -->
            <section class="relative h-screen bg-cover bg-center" style="background-image: url('/images/HeroSelection.png');">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center text-white">
                    <div>
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Selamat datang di Kubikal</h1>
                        <p class="text-lg md:text-xl mb-8">Ijinkan kita memandu kalian untuk merasakan kehangatan seperti di rumah </p>
                        <a href="#gallery" class="bg-white text-gray-800 py-2 px-6 rounded-md font-semibold hover:bg-gray-200 transition duration-300">
                            Lihat Galeri
                        </a>
                    </div>
                </div>
            </section>

            <!-- GALLERY SECTION -->
            <section id="gallery" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto max-w-6xl">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 scroll-animate fade-up">Gallery</h2>
                        <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto scroll-animate fade-up" style="animation-delay: 0.1s;">
                            Take a peek into our world of handcrafted coffee and delicious bites that await you.
                        </p>
                    </div>

                    <!-- Grid 4 Gambar -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
                        <div 
                            v-for="(img, index) in displayImages" 
                            :key="index"
                            class="aspect-square rounded-lg overflow-hidden shadow-lg cursor-pointer group relative scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }"
                            @click="openLightbox(index)"
                        >
                            <img 
                                :src="img" 
                                :alt="`Gallery image ${index + 1}`"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                        </div>
                    </div>

                    <!-- Tombol View All Gallery -->
                    <div class="flex justify-center md:justify-end mt-8">
                        <Link 
                            :href="route('gallery.index')" 
                            class="inline-flex items-center px-8 py-3 bg-gray-900 dark:bg-gray-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-gray-800 dark:hover:bg-gray-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            View All Gallery
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </section>

            <!-- OUR STORY -->
            <section id="our-story" class="py-16 px-4 md:px-8 lg:px-16 bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <div class="w-full md:w-1/2 scroll-animate fade-up">
                        <img src="/images/About.png" alt="Our Story" class="rounded-lg shadow-lg w-full h-64 md:h-80 object-cover bg-gray-300 dark:bg-gray-700">
                    </div>
                    <div class="w-full md:w-1/2 text-center md:text-left scroll-animate fade-up" style="animation-delay: 0.2s;">
                        <h2 class="text-3xl font-bold mb-4">Our Story</h2>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Setiap perjalanan selalu ada awalnya, cerita kita berawal di November 2024. berangkat dari kebiasaan orang Sulawesi Selatan untuk memulai hari dengan kopi, kita berusaha untuk menemani hari kalian dengan menyajikan ruang, makanan,dan minuman.
                        </p>
                    </div>
                </div>
            </section>

            <!-- EVENTS -->
            <section id="events" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto text-center">
                    <h2 class="text-3xl font-bold mb-8 scroll-animate fade-up">Upcoming Events</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div v-for="(event, index) in events" :key="event.id_event" @click="openEventModal(event)"
                            class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:-translate-y-2 cursor-pointer transition scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }">
                            <img :src="event.gambar_url || '/images/placeholder-event.jpg'" class="rounded-md mb-4 w-full h-40 object-cover">
                            <h3 class="text-xl font-semibold mb-2">{{ event.nama_event }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ event.deskripsi_event }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- BEST SELLER -->
            <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
                <div class="container mx-auto">
                    <h2 class="text-3xl font-bold mb-12 text-center scroll-animate fade-up">Our Best Sellers</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                        <div v-for="(menu, index) in favoriteMenus" :key="menu.id_menu" @click="openMenuModal(menu)"
                            class="menu-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden cursor-pointer hover:-translate-y-1 transition scroll-animate scale-in"
                            :style="{ animationDelay: `${index * 0.1}s` }">
                            <div class="aspect-square overflow-hidden">
                                <img :src="menu.gambar_url || '/images/placeholder.jpg'" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-base mb-1 truncate">{{ menu.nama_menu }}</h4>
                                <p class="text-xs text-gray-600 line-clamp-2">{{ menu.deskripsi_menu }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 flex justify-end">
                        <Link :href="route('menu.index')" class="bg-gray-800 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 shadow-md">more menu</Link>
                    </div>
                </div>
            </section>
        </main>

        <AppFooter class="mt-auto" />
    </div>

    <!-- LIGHTBOX -->
    <Teleport to="body">
        <div v-if="isLightboxOpen" class="fixed inset-0 z-[60] bg-black bg-opacity-95 flex items-center justify-center p-4" @click="closeLightbox">
            <button class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 z-50" @click="closeLightbox">×</button>
            <button @click.stop="prevLightbox" class="absolute left-4 text-white p-4 hover:bg-white/10 rounded-full transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <img :src="allImages[lightboxImageIndex]" class="max-w-full max-h-[90vh] object-contain rounded shadow-2xl" @click.stop>
            <button @click.stop="nextLightbox" class="absolute right-4 text-white p-4 hover:bg-white/10 rounded-full transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </Teleport>

    <!-- MODALS -->
    <MenuDetailModal :show="showMenuModal" :item="selectedMenu" @close="closeMenuModal" />
    <EventDetailModal :show="showEventModal" :item="selectedEvent" @close="closeEventModal" />
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'
import MenuDetailModal from '@/Components/MenuDetailModal.vue'
import EventDetailModal from '@/Components/EventDetailModal.vue'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    events: Array,
    favoriteMenus: Array,
    galleries: Object
})

// === LOGIKA GALERI ===
const displayImages = computed(() => {
    if (props.galleries?.favorites?.length > 0) {
        return props.galleries.favorites.map(g => g.gambar_url).slice(0, 4);
    }
    return [];
});

const allImages = computed(() => {
    if (props.galleries?.favorites?.length > 0) {
        return props.galleries.favorites.map(g => g.gambar_url);
    }
    return [];
});

const isLightboxOpen = ref(false);
const lightboxImageIndex = ref(0);

const openLightbox = (index) => {
    lightboxImageIndex.value = allImages.value.indexOf(displayImages.value[index]);
    if (lightboxImageIndex.value === -1) lightboxImageIndex.value = 0;
    isLightboxOpen.value = true;
};

const closeLightbox = () => { isLightboxOpen.value = false; };
const nextLightbox = () => { lightboxImageIndex.value = (lightboxImageIndex.value + 1) % allImages.value.length; };
const prevLightbox = () => { lightboxImageIndex.value = (lightboxImageIndex.value - 1 + allImages.value.length) % allImages.value.length; };

// Menu & Event Modal
const showMenuModal = ref(false);
const selectedMenu = ref(null);
const showEventModal = ref(false);
const selectedEvent = ref(null);

const openMenuModal = (menu) => { selectedMenu.value = menu; showMenuModal.value = true; };
const closeMenuModal = () => { showMenuModal.value = false; selectedMenu.value = null; };
const openEventModal = (event) => { selectedEvent.value = event; showEventModal.value = true; };
const closeEventModal = () => { showEventModal.value = false; selectedEvent.value = null; };

// Scroll Animation Setup
let observer = null

const setupScrollAnimation = () => {
  if (observer) {
    observer.disconnect()
  }

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

<style scoped>
.overflow-y-auto::-webkit-scrollbar { width: 8px; }
.overflow-y-auto::-webkit-scrollbar-track { background: #1a1a1a; }
.overflow-y-auto::-webkit-scrollbar-thumb { background: #4a4a4a; border-radius: 4px; }
.overflow-y-auto::-webkit-scrollbar-thumb:hover { background: #555; }

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

/* Scale In */
.scale-in {
  transform: scale(0.8);
  opacity: 0;
}

.scale-in.animate-in {
  transform: scale(1);
  opacity: 1;
}
</style>
