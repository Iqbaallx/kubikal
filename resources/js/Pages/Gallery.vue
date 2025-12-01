<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

const props = defineProps({
    images: Array, // Semua gambar dari database
    canLogin: Boolean,
    canRegister: Boolean,
})

const isLightboxOpen = ref(false)
const lightboxIndex = ref(0)

const openLightbox = (index) => {
    lightboxIndex.value = index
    isLightboxOpen.value = true
}

const closeLightbox = () => { isLightboxOpen.value = false }
const nextImage = () => { lightboxIndex.value = (lightboxIndex.value + 1) % props.images.length }
const prevImage = () => { lightboxIndex.value = (lightboxIndex.value - 1 + props.images.length) % props.images.length }
</script>

<template>
    <Head title="Galeri Lengkap" />

    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col">
        <AppHeader :canLogin="canLogin" :canRegister="canRegister" />

        <main class="flex-1 container mx-auto px-4 py-12">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Galeri Kami</h1>
                <p class="text-gray-600 dark:text-gray-400">Momen-momen terbaik di Kubikal Space</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div 
                    v-for="(img, index) in images" 
                    :key="img.id_galeri"
                    class="aspect-square rounded-xl overflow-hidden cursor-pointer group relative shadow-md hover:shadow-xl transition-all duration-300"
                    @click="openLightbox(index)"
                >
                    <img 
                        :src="img.gambar_url" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        alt="Gallery Image"
                    >
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                        <span class="text-white opacity-0 group-hover:opacity-100 font-semibold tracking-wider">ZOOM</span>
                    </div>
                </div>
            </div>

            <div v-if="images.length === 0" class="text-center py-20 text-gray-500">
                Belum ada galeri foto.
            </div>
            
            <div class="mt-12 text-center">
                <Link :href="route('home')" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    &larr; Kembali ke Home
                </Link>
            </div>
        </main>

        <AppFooter />
    </div>

    <Teleport to="body">
        <div v-if="isLightboxOpen" class="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4" @click="closeLightbox">
            <button class="absolute top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 z-50">×</button>
            <button @click.stop="prevImage" class="absolute left-4 text-white p-4 hover:bg-white/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg></button>
            
            <img v-if="images[lightboxIndex]" :src="images[lightboxIndex].gambar_url" class="max-w-full max-h-[90vh] object-contain rounded shadow-2xl" @click.stop>
            
            <button @click.stop="nextImage" class="absolute right-4 text-white p-4 hover:bg-white/10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></button>
        </div>
    </Teleport>
</template>