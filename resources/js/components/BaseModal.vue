<template>
    <div v-if="isVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-4 rounded shadow-lg w-11/12 md:w-1/3">
        <div class="flex justify-between items-center border-b pb-2 mb-4">
          <h3 class="text-xl font-semibold">{{ title }}</h3>
          <button @click="close" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div>
          <slot></slot>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, defineEmits, watch } from 'vue';

  const props = defineProps({
    title: {
      type: String,
      default: 'Modal Title'
    },
    visible: {
      type: Boolean,
      default: false
    }
  });

  const emit = defineEmits(['update:visible']);

  const isVisible = ref(props.visible);

  watch(() => props.visible, (newValue) => {
    isVisible.value = newValue;
  });

  function close() {
    emit('update:visible', false);
  }
  </script>

  <style scoped>
  /* Add any additional styling for the modal here */
  </style>
