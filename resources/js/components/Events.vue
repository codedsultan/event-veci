<template>
    <div>
      <div class="form-group row">
        <div class="col-sm-4">
          <input
            type="text"
            class="form-control"
            id="event"
            v-model="search"
            placeholder="Search Event"
            @input="debouncedSearch"
          />
        </div>
      </div>

      <div class="event-wrap">
        <div class="row">
          <h3 v-if="events.data.length === 0" class="text-center mt-5 mb-5 ml-5">
            <i>Sorry! No events found to show</i>
          </h3>
          <div
            class="col-lg-3 col-md-4 col-sm-6 text-center"
            v-for="event in events.data"
            :key="event.id"
          >
            <div class="event-panel">
              <div class="event">
                <a :href="`/events/${event.slug}`">
                  <div class="event-img">
                    <img :src="event.image_path" />
                  </div>
                  <div class="event-text">
                    <div class="event-time">
                      <p>
                        <i class="far fa-clock"></i>
                        <span>{{ event.strtdt | timeDate }},</span>
                        <span>{{ event.strttm }}</span>
                      </p>
                    </div>
                    <p class="event-name">{{ event.name }}</p>
                    <p class="event-location">{{ event.location }}</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <pagination :data="events" @pagination-change-page="getResults"></pagination>
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
