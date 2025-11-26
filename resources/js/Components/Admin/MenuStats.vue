<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <StatCard 
      title="Total Menu"
      :value="stats.totalMenu"
      icon="list"
      gradient="from-blue-500 to-blue-600"
      shadowColor="shadow-blue-200"
      hoverColor="hover:border-blue-200"
    />
    
    <StatCard 
      title="Minuman"
      :value="stats.minuman"
      icon="coffee"
      gradient="from-purple-500 to-purple-600"
      shadowColor="shadow-purple-200"
      hoverColor="hover:border-purple-200"
    />
    
    <StatCard 
      title="Makanan"
      :value="stats.makanan"
      icon="food"
      gradient="from-orange-500 to-orange-600"
      shadowColor="shadow-orange-200"
      hoverColor="hover:border-orange-200"
    />
    
    <StatCard 
      title="Menu Favorit"
      :value="stats.favorit"
      icon="star"
      gradient="from-amber-500 to-amber-600"
      shadowColor="shadow-amber-200"
      hoverColor="hover:border-amber-200"
    />
  </div>
</template>

<script setup>
import StatCard from '@/Components/Admin/StatCard.vue';

defineProps({
  stats: { type: Object, required: true }
});
</script>