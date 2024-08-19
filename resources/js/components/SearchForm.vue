<template>
    <div class="search">
      <input
        type="text"
        class="search-input"
        placeholder="Search Event"
        v-model="query"
        @click="addItem"
        @keyup.enter="isOpen = true"
      />
      <ul
        class="search-ul"
        v-if="results.length > 0 && query && isOpen"
      >
        <li class="search-li" v-for="result in results.slice(0, 10)" :key="result.id">
          <a :href="result.url">
            <div v-text="result.title"></div>
          </a>
        </li>
        <li>
          <span @click="close"><b>Close</b></span>
        </li>
      </ul>
    </div>
  </template>
  <script setup>
  import { ref, watch } from 'vue';
  import axios from 'axios';

  const query = ref('');
  const results = ref([]);
  const isOpen = ref(true);

  // Watch for changes in the `query` and trigger the search
  watch(query, (newQuery) => {
    if (newQuery) {
      searchEvents();
    } else {
      results.value = [];
    }
  });

  // Method to perform the search
  const searchEvents = async () => {
    try {
      const response = await axios.get('events/search', { params: { query: query.value } });
      results.value = response.data;
    } catch (error) {
      // Handle error
      console.error('Error fetching search results:', error);
    }
  };

  // Method to open the results
  const addItem = () => {
    isOpen.value = true;
  };

  // Method to close the results and clear the search
  const close = () => {
    isOpen.value = false;
    query.value = '';
    results.value = [];
  };
  </script>
