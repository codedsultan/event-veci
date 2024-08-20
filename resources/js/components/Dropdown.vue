<template>
    <div class="bg-white vue-dropdown" @click="toggleDropdown">
      <!-- Trigger -->
       <!-- <p>This is the drop dropdown</p> -->
      <slot name="trigger"></slot>

      <!-- Menu links -->
      <transition name="fade">
        <div class="vue-dropdown_item" v-show="isOpen">
          <slot></slot>
        </div>
      </transition>
    </div>
  </template>
  <script setup>
  import { ref, watch, onMounted, onUnmounted } from 'vue';

  // Reactive state
  const isOpen = ref(false);

  // Method to toggle the dropdown menu
  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };

  // Method to close the dropdown if clicked outside
  const closeIfClickedOutside = (event) => {
    if (!event.target.closest('.vue-dropdown')) {
      isOpen.value = false;
    }
  };

  // Watch for changes to `isOpen` to add or remove the event listener
  watch(isOpen, (newValue) => {
    if (newValue) {
      document.addEventListener('click', closeIfClickedOutside);
    } else {
      document.removeEventListener('click', closeIfClickedOutside);
    }
  });

  // Cleanup event listener on component unmount
  onUnmounted(() => {
    document.removeEventListener('click', closeIfClickedOutside);
  });
  </script>
