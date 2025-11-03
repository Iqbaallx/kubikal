<template>
  <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border border-gray-100">
    <div class="flex items-start justify-between mb-3">
      <div class="text-5xl font-bold text-gray-800 leading-none">
        {{ value }}
      </div>
      <div class="text-3xl opacity-80">
        {{ icon }}
      </div>
    </div>
    <div class="text-gray-600 text-sm font-medium flex items-center gap-2 mt-2">
      <span>{{ label }}</span>
    </div>
  </div>
</template>

<script setup>
defineProps({
  value: {
    type: [Number, String],
    required: true
  },
  label: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    default: '📊'
  }
});
</script>