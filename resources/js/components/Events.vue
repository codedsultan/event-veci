<template>
<div class="max-w-7xl mx-auto p-6">
  <div class="mb-6">
    <input
      type="text"
      id="event"
      v-model="search"
      placeholder="Search Event"
      @input="debouncedSearch"
      class="w-full sm:w-1/3 p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
    />
  </div>

  <div v-if="events.data?.length === 0" class="text-center mt-10">
    <h3 class="text-xl italic text-gray-500">Sorry! No events found to show</h3>
  </div>

  <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <div
      v-for="event in events.data"
      :key="event.id"
      class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
    >
      <a :href="`/events/${event.slug}`" class="block">
        <img :src="event.image_path" alt="Event Image" class="w-full h-48 object-cover" />
        <div class="p-4">
          <div class="flex items-center justify-between text-sm text-gray-600">
            <p>
              <i class="far fa-clock"></i>
              <span>{{ event.strtdt | timeDate }},</span>
              <span>{{ event.strttm }}</span>
            </p>
          </div>
          <h3 class="text-lg font-semibold mt-2">{{ event.name }}</h3>
          <p class="text-gray-500 mt-1">{{ event.location }}</p>
        </div>
      </a>
    </div>
  </div>

  <div class="mt-8">
    <pagination :data="events" @pagination-change-page="getResults"></pagination>
  </div>
</div>

  </template>
  <script setup>
  import { ref, onMounted, watch } from 'vue';
  import axios from 'axios';
  import _ from 'lodash'; // For debounce

  // Define reactive state
  const events = ref({});
  const search = ref('');

  // Load initial events
  const loadEvents = async () => {
    try {
      const response = await axios.get('/api/events');
      events.value = response.data;
    } catch (error) {
      console.error('Failed to load events:', error);
    }
  };

  // Fetch paginated results
  const getResults = async (page = 1) => {
    try {
      const response = await axios.get(`/api/events?page=${page}`);
      events.value = response.data;
      console.log(events.value)
    } catch (error) {
      console.error('Failed to fetch results:', error);
    }
  };

  // Debounced search function
  const debouncedSearch = _.debounce(async () => {
    try {
      const response = await axios.get(`/api/findEvents?q=${search.value}`);
      events.value = response.data;
    } catch (error) {
      console.error('Search failed:', error);
    }
  }, 325);

  // Watch for changes in search input
  watch(search, debouncedSearch);

  // Load events on component mount
  onMounted(() => {
    loadEvents();
  });
  </script>
