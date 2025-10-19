<template>
    <Head title="Home" />

    <div class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <section class="relative h-screen bg-cover bg-center" style="background-image: url('')">
          <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-center text-white">
            <div>
              <h1 class="text-4xl md:text-6xl font-bold mb-4">Crafted Coffee & Delicious Bites</h1>
              <p class="text-lg md:text-xl mb-8">Selamat datang di Kubikal Space</p>
              <a href="#our-story" class="bg-white text-gray-800 py-2 px-6 rounded-md font-semibold hover:bg-gray-200 transition duration-300">
                Learn More
              </a>
            </div>
          </div>
        </section>

        <section id="our-story" class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
          <div class="container mx-auto flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="w-full md:w-1/2">
              <img src="" alt="Our Story" class="rounded-lg shadow-lg w-full h-64 md:h-80 object-cover bg-gray-300 dark:bg-gray-700"> </div>
            <div class="w-full md:w-1/2 text-center md:text-left">
              <h2 class="text-3xl font-bold mb-4">Our Story</h2>
              <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Didirikan pada tahun 20xx, Kubikal Space lahir dari kecintaan terhadap kopi berkualitas dan keinginan untuk menciptakan ruang komunitas yang hangat. Kami percaya pada kekuatan secangkir kopi untuk menghubungkan orang dan menginspirasi momen.
                <br><br>
                Kami berkomitmen untuk menyajikan biji kopi terbaik yang diproses dengan cermat, serta makanan pendamping yang lezat, dibuat dari bahan-bahan segar pilihan. Datang dan rasakan pengalaman Kubikal Space.
              </p>
            </div>
          </div>
        </section>

        <section class="py-12 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
          <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
            <div>
              <div class="flex items-center justify-center mb-2">
                <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-xl font-semibold">Jam Buka & Tutup</h3>
              </div>
              <p class="text-gray-600 dark:text-gray-400">Setiap Hari: 08:00 - 22:00</p>
            </div>
            <div>
              <div class="flex items-center justify-center mb-2">
                 <svg class="w-6 h-6 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <h3 class="text-xl font-semibold">Lokasi</h3>
              </div>
              <p class="text-gray-600 dark:text-gray-400">Jl. Merdeka No. 123, Boyolali, Jawa Tengah</p>
              <a href="#" class="mt-2 inline-block text-blue-600 dark:text-blue-400 hover:underline">Lihat Peta</a>
            </div>
          </div>
        </section>


        <section class="py-16 px-4 md:px-8 lg:px-16 bg-white dark:bg-gray-800">
          <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Upcoming Events</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2">
                <img src="" alt="Live Acoustic Night" class="rounded-md mb-4 w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <h3 class="text-xl font-semibold mb-2">Live Acoustic Night</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Setiap Jumat malam, nikmati alunan musik akustik santai sambil menikmati kopi favoritmu.</p>
              </div>
              <div class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2">
                <img src="" alt="Latte Art Workshop" class="rounded-md mb-4 w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <h3 class="text-xl font-semibold mb-2">Latte Art Workshop</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Pelajari seni membuat latte art yang indah bersama barista kami. Terbatas!</p>
              </div>
              <div class="event-card bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md transform transition duration-300 hover:-translate-y-2">
                <img src="" alt="Holiday Specials Tasting" class="rounded-md mb-4 w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <h3 class="text-xl font-semibold mb-2">Holiday Specials Tasting</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Cicipi menu spesial liburan kami yang baru, mulai dari minuman hingga makanan penutup.</p>
              </div>
            </div>
          </div>
        </section>

        <section class="py-16 px-4 md:px-8 lg:px-16 bg-gray-200 dark:bg-gray-700">
          <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Our Best Sellers</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
              <div @click="openMenuModal({ name: 'Cappuccino', price: 'Rp 25.000', description: 'Kopi susu klasik dengan foam lembut dan taburan cokelat di atasnya. Menggunakan espresso berkualitas tinggi dipadu dengan susu segar.', image: '' })"
                   class="menu-item bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                <img src="" alt="Cappuccino" class="w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <div class="p-4">
                  <h4 class="font-semibold">Cappuccino</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Rp 25.000</p>
                </div>
              </div>
              <div @click="openMenuModal({ name: 'Latte', price: 'Rp 25.000', description: 'Perpaduan espresso dan susu steamed dengan sedikit lapisan foam di atasnya.', image: '' })"
                   class="menu-item bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                <img src="" alt="Latte" class="w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <div class="p-4">
                  <h4 class="font-semibold">Latte</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Rp 25.000</p>
                </div>
              </div>
              <div @click="openMenuModal({ name: 'Espresso', price: 'Rp 20.000', description: 'Ekstraksi kopi murni dengan crema tebal, dasar dari banyak minuman kopi.', image: '' })"
                   class="menu-item bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                <img src="" alt="Espresso" class="w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <div class="p-4">
                  <h4 class="font-semibold">Espresso</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Rp 20.000</p>
                </div>
              </div>
              <div @click="openMenuModal({ name: 'Cold Brew', price: 'Rp 30.000', description: 'Kopi yang diseduh dengan air dingin selama berjam-jam, menghasilkan rasa yang halus dan rendah asam.', image: '' })"
                   class="menu-item bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:-translate-y-2 cursor-pointer">
                <img src="" alt="Cold Brew" class="w-full h-40 object-cover bg-gray-300 dark:bg-gray-600">
                <div class="p-4">
                  <h4 class="font-semibold">Cold Brew</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Rp 30.000</p>
                </div>
              </div>
            </div>
             <div class="mt-8 flex justify-end">
              <a href="#" class="bg-gray-800 text-white dark:bg-gray-600 dark:text-gray-200 py-2 px-5 rounded-md font-semibold hover:bg-gray-700 dark:hover:bg-gray-500 transition duration-300">
                More Menu
              </a>
            </div>
          </div>
        </section>

        <footer class="bg-gray-800 dark:bg-black text-gray-400 dark:text-gray-500 py-8 px-4 text-center">
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

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import MenuDetailModal from '@/Components/MenuDetailModal.vue'; // Pastikan path ini benar

// State untuk modal
const showMenuModal = ref(false);
const selectedMenu = ref(null);

// Fungsi untuk membuka modal
const openMenuModal = (menuData) => {
  selectedMenu.value = menuData;
  showMenuModal.value = true;
};

// Fungsi untuk menutup modal
const closeMenuModal = () => {
  showMenuModal.value = false;
  selectedMenu.value = null; // Reset menu yang dipilih
};
</script>

<style scoped>
/* Tambahkan style khusus jika diperlukan */
.h-screen {
  height: 100vh;
}
</style>