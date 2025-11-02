<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

// Icon sederhana untuk menu (bisa diganti dengan SVG)
const DashboardIcon = 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1V9a1 1 0 011-1h2a1 1 0 011 1v10a1 1 0 001 1h3m-6 0a1 1 0 001-1V9a1 1 0 011-1h2a1 1 0 011 1v10a1 1 0 001 1h3';
const MenuListIcon = 'M4 6h16M4 12h16m-7 6h7';
const EventIcon = 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z';
const UserIcon = 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1H9';

const showingNavigationDropdown = ref(false);

// Kita buat fungsi logout palsu, karena kita tidak login
const logout = () => {
    alert('Ini adalah fungsi Log Out (demo)');
    router.get('/'); // Kembali ke home
};
</script>

<template>
    <div>
        <Head :title="$page.props.title || 'Admin Panel'" />

        <div class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
            <aside class="w-64 bg-gray-800 dark:bg-gray-900 text-white flex-shrink-0 flex flex-col">
                <div class="h-16 flex items-center justify-center shadow-md">
                     <img src="/images/LOGO.png" alt="Logo" class="w-12 h-12">
                     <span class="ml-2 text-xl font-semibold">Kubikal Admin</span>
                </div>
                
                <nav class="flex-grow mt-4">
                    <Link 
                        :href="route('admin.dashboard')" 
                        :class="{ 'bg-gray-700': route().current('admin.dashboard') }"
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" v-html="DashboardIcon"></svg>
                        <span class="ml-3">Dashboard</span>
                    </Link>
                    
                    <Link href="#" class="flex items-center mt-2 px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" v-html="MenuListIcon"></svg>
                        <span class="ml-3">Manage Menu</span>
                    </Link>
                    
                     <Link href="#" class.="flex items-center mt-2 px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" v-html="EventIcon"></svg>
                        <span class="ml-3">Manage Events</span>
                    </Link>

                    <Link href="#" class="flex items-center mt-2 px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" v-html="UserIcon"></svg>
                        <span class="ml-3">Manage Users</span>
                    </Link>
                </nav>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            {{ $page.props.title || 'Dashboard' }}
                        </h1>
                        
                        <div class="relative">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ $page.props.auth.admin.name }}</div> 
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                            
                            <div v-show="showingNavigationDropdown" @click="showingNavigationDropdown = false" class="fixed inset-0 z-10"></div>
                            
                            <div v-show="showingNavigationDropdown" class="absolute z-20 right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                                <button @click="logout" type="button" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">
                                    Log Out
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-6">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>