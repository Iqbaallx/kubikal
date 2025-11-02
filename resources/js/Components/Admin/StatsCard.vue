<template>
  <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow">
    <div class="text-3xl font-bold">{{ value }}</div>
    <div class="text-gray-600 text-sm mt-1 flex items-center gap-1">
      <span>{{ icon }}</span>
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