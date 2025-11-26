<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import MenuDetailModal from '@/Components/MenuDetailModal.vue'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

const props = defineProps({
  menus: Object,
  canLogin: Boolean,
  canRegister: Boolean,
})

const activeTab = ref('minuman')
const activeSubTab = ref('kopi')
const showMenuModal = ref(false)
const selectedMenu = ref(null)

const formatCurrency = (value) => {
  if (!value) value = 0
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value)
}

const displayedMenus = computed(() => {
  if (activeTab.value === 'makanan') {
    return props.menus.makanan || []
  } else {
    const minuman = props.menus.minuman || []
    if (activeSubTab.value === 'kopi') {
      return minuman.filter(menu => menu.kategori === 'coffee')
    } else {
      return minuman.filter(menu => menu.kategori === 'non-coffee')
    }
  }
})

const openMenuModal = (menuData) => {
  selectedMenu.value = menuData
  showMenuModal.value = true
}

const closeMenuModal = () => {
  showMenuModal.value = false
  selectedMenu.value = null
}

const setActiveTab = (tab) => {
  activeTab.value = tab
  if (tab === 'minuman') activeSubTab.value = 'kopi'
  
  // Re-observe elements after tab change
  setTimeout(() => {
    setupScrollAnimation()
  }, 100)
}

const setActiveSubTab = (sub) => {
  activeSubTab.value = sub
  
  // Re-observe elements after subtab change
  setTimeout(() => {
    setupScrollAnimation()
  }, 100)
}

// Scroll Animation Setup
let observer = null

const setupScrollAnimation = () => {
  // Disconnect existing observer
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

  // Observe all elements with scroll-animate class
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
  <Head title="Menu" />

  <div class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
    <AppHeader :canLogin="props.canLogin" :canRegister="props.canRegister" />

    <main class="pt-10">
      <div class="container mx-auto px-4 sm:px-8 lg:px-8 py-10">
        <h1 class="text-4xl font-bold text-center mb-10 scroll-animate fade-up">Menu Kami</h1>

        <!-- Tab Utama -->
        <div class="flex justify-center mb-8 border-b border-gray-300 dark:border-gray-700 scroll-animate fade-up" style="animation-delay: 0.1s;">
          <button
            @click="setActiveTab('minuman')"
            :class="[
              'py-2 px-6 text-lg font-medium transition duration-150 ease-in-out',
              activeTab === 'minuman'
                ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 border-b-2 border-transparent'
            ]"
          >
            Minuman
          </button>
          <button
            @click="setActiveTab('makanan')"
            :class="[
              'py-2 px-6 text-lg font-medium transition duration-150 ease-in-out',
              activeTab === 'makanan'
                ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 border-b-2 border-transparent'
            ]"
          >
            Makanan
          </button>
        </div>

        <!-- Sub Tab Minuman -->
        <div
          v-if="activeTab === 'minuman'"
          class="flex justify-center mb-8 space-x-4 scroll-animate fade-up"
          style="animation-delay: 0.2s;"
        >
          <button
            @click="setActiveSubTab('kopi')"
            :class="[
              'py-1 px-4 text-sm rounded-md transition duration-150 ease-in-out',
              activeSubTab === 'kopi'
                ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'
            ]"
          >
            Kopi
          </button>
          <button
            @click="setActiveSubTab('non-kopi')"
            :class="[
              'py-1 px-4 text-sm rounded-md transition duration-150 ease-in-out',
              activeSubTab === 'non-kopi'
                ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300'
                : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'
            ]"
          >
            Non-Kopi
          </button>
        </div>

        <!-- Grid Menu -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 md:gap-8">
          <div
            v-for="(menu, index) in displayedMenus"
            :key="menu.id_menu"
            @click="openMenuModal(menu)"
            class="menu-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer scroll-animate scale-in"
            :style="{ animationDelay: `${index * 0.05}s` }"
          >
            <div class="aspect-square overflow-hidden">
              <img
                :src="menu.gambar_url || '/images/placeholder.jpg'"
                :alt="menu.nama_menu"
                class="w-full h-full object-cover bg-gray-300 dark:bg-gray-600"
                loading="lazy"
              />
            </div>
            <div class="p-4">
              <h4 class="font-semibold text-base truncate">{{ menu.nama_menu }}</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ formatCurrency(menu.harga_menu) }}
              </p>
            </div>
          </div>

          <!-- Jika tidak ada menu -->
          <div
            v-if="displayedMenus.length === 0"
            class="col-span-full text-center text-gray-500 py-10 text-sm scroll-animate fade-up"
          >
            Menu belum tersedia.
          </div>
        </div>
      </div>
    </main>

    <AppFooter class="mt-auto" />
  </div>

  <!-- Modal -->
  <MenuDetailModal :show="showMenuModal" :item="selectedMenu" @close="closeMenuModal" />
</template>

<style scoped>
.menu-card img {
  transition: transform 0.3s ease;
}
.menu-card:hover img {
  transform: scale(1.05);
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