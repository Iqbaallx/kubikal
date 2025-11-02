<script setup>
import { Head, Link } from '@inertiajs/vue3';

// Karena ini layout admin, kita tidak menggunakan AuthenticatedLayout
// Ini adalah layout admin yang sederhana
</script>

<template>
    <Head title="Admin Dashboard" />

    <div class="flex h-screen bg-gray-100">
        <aside class="w-64 bg-gray-800 text-white p-4">
            <h1 class="text-2xl font-bold mb-4">Admin Panel</h1>
            <nav>
                <ul>
                    <li class="mb-2">
                        <Link 
                            :href="route('admin.dashboard')" 
                            class="block p-2 rounded hover:bg-gray-700"
                            :class="{ 'bg-gray-900': $page.url.startsWith('/admin/dashboard') }"
                        >
                            Dashboard
                        </Link>
                    </li>
                    <li class="mt-auto pt-4 border-t border-gray-700">
                         <Link 
                            :href="route('admin.logout')" 
                            method="post" 
                            as="button" 
                            class="w-full text-left p-2 rounded hover:bg-gray-700"
                         >
                            Logout
                         </Link>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <header class="mb-6">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </header>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Selamat datang di Dashboard Admin!
                </div>
            </div>
        </main>
    </div>
</template>