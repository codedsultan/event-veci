<template>
    <div>
      <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded">
        View Event Guests
      </button>

      <BaseModal :visible="showModal" @update:visible="showModal = $event" title="Participating Event Guests">
        <div class="relative p-4 bg-white shadow-lg rounded-lg max-w-3xl mx-auto">
  <!-- Close Button -->
  <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-semibold" @click="showModal = false">
    &times;
  </button>

  <!-- Guest List -->
  <div v-if="guests.length > 0">
    <p class="text-center text-lg font-semibold mb-4">
      <b>{{ guests.length }} guests are going to attend this event</b>
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <div v-for="guest in guests" :key="guest.id" class="flex flex-col items-center text-center">
        <a :href="`/profile/${guest.id}`" target="_blank" class="block">
          <img :src="guest.image" alt="Guest Image" class="w-24 h-24 object-cover rounded-full mb-2">
          <p class="text-sm font-medium text-gray-800">
            <b>{{ guest.name }}</b>
          </p>
        </a>
      </div>
    </div>
  </div>

  <!-- No Guests Message -->
  <div v-else>
    <h3 class="text-center text-lg font-semibold mt-5 mb-3 text-gray-600">
      No Event Participating guest yet
    </h3>
  </div>
</div>
      </BaseModal>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import BaseModal from './BaseModal.vue';

  // Example guest data - this should come from your data source
  const guests = ref([
    { id: 1, name: 'John Doe', image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcREMyvRO0cuDTlEXwAwDVQE3szE6ezl7USqNL_n9D_5w8zRCGtk' },
    // Add more guest objects as needed
  ]);

  const showModal = ref(false);
  </script>
