<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <header class="bg-white shadow-sm sticky top-0 z-10 border-b border-gray-200">
        <nav class="container mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            <Link href="/" class="flex items-center space-x-3">
                <img 
                    src="/images/logo.png" 
                    alt="Kubikal Space Logo" 
                    class="h-12 w-auto object-contain"
                >
                <span class="font-semibold text-xl">Kubikal Space</span>
            </Link>

            <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-10">
                <Link href="/" class="text-gray-600 hover:text-gray-900 transition">Home</Link>
                <Link href="/#our-story" class="text-gray-600 hover:text-gray-900 transition">Our Story</Link>
                <Link href="/#events" class="text-gray-600 hover:text-gray-900 transition">Event</Link>
                <Link :href="route('menu.index')" class="text-gray-600 hover:text-gray-900 transition">Menu</Link>
            </div>
        </nav>
    </header>
</template>