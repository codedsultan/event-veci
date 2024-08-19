<template>
    <div v-if="authorize('isAdmin')">
      <p class="Dashboard-heading">Events</p>
      <p class="Dashboard-heading">Total Events: {{ counts.length }}</p>
      <p class="Dashboard-heading">Event Status: {{ status }}</p>

      <div class="form-group">
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
        <div class="dropdown float-right">
          <button
            class="btn btn-primary dropdown-toggle"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Select Event Option
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#" @click.prevent="all">
              <span v-if="active" class="text-primary">
                <i class="far fa-check-circle"></i> <b>All Events</b>
              </span>
              <span v-else>All Events</span>
            </a>
            <a class="dropdown-item" href="#" @click.prevent="live">
              <span v-if="liveactive" class="text-primary">
                <i class="far fa-check-circle"></i> <b>Live Events</b>
              </span>
              <span v-else>Live Events</span>
            </a>
            <a class="dropdown-item" href="#" @click.prevent="drafted">
              <span v-if="draftedactive" class="text-primary">
                <i class="far fa-check-circle"></i> <b>Drafted Events</b>
              </span>
              <span v-else>Drafted Events</span>
            </a>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Event Name</th>
              <th scope="col">Start Date</th>
              <th scope="col">Status</th>
              <th scope="col">Price</th>
              <th scope="col">Ticket Sold</th>
              <th scope="col">Tickets Left</th>
              <th scope="col">Current Status</th>
              <th scope="col">Created By</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="event in events.data" :key="event.id">
              <td>
                <a :href="`/events/${event.slug}`" class="text-user" target="_blank">{{ event.name }}</a>
              </td>
              <td>{{ event.strtdt | timeDate }}</td>
              <td v-if="todaydate > event.enddt">
                <span class="text-danger"><b>Event Over</b></span>
              </td>
              <td v-else>
                <span class="text-primary"><b>Event Open</b></span>
              </td>
              <td>{{ event.price }}</td>
              <td>{{ event.sold }}</td>
              <td>{{ event.qty }}</td>
              <td v-if="event.deleted_at == null">
                <span class="active"><b>Active</b></span>
              </td>
              <td v-else>
                <span class="text-warning"><b>Drafted</b></span>
              </td>
              <td>
                <a :href="`/profile/${event.user_id}`" class="text-user" target="_blank">{{ event.user.name }}</a>
              </td>
              <td v-if="event.deleted_at == null">
                <button class="btn btn-sm btn-primary" @click="draft(event.slug)">Draft</button>
                <button class="btn btn-sm btn-danger" @click="destroy(event.slug)">Delete</button>
              </td>
              <td v-else>
                <button class="btn btn-success btn-sm" @click="unDraft(event.slug)">Live</button>
                <button class="btn btn-danger btn-sm" @click="draftDelete(event.slug)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <pagination :data="events" @pagination-change-page="getResults"></pagination>
    </div>

    <div v-else class="text-center mt-5">
      <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
      <a href="/" class="btn btn-primary mt-2">Go Back</a>
    </div>
  </template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import _ from 'lodash';
import swal from 'sweetalert2';

// Define reactive state
const events = ref({});
const counts = ref([]);
const search = ref('');
const todaydate = ref(new Date().toJSON().slice(0, 10).replace(/-/g, '-'));
const status = ref('all');
const active = ref(false);
const liveactive = ref(false);
const draftedactive = ref(false);

// Load events
const loadEvents = async () => {
  try {
    const response = await axios.get('/api/allevents');
    events.value = response.data;
    status.value = 'All Events';
    active.value = true;
    draftedactive.value = false;
    liveactive.value = false;
    search.value = '';
  } catch (error) {
    console.error('Failed to load events:', error);
  }
};

// Load event counts
const loadCount = async () => {
  try {
    const response = await axios.get('/api/eventscount');
    counts.value = response.data;
  } catch (error) {
    console.error('Failed to load event counts:', error);
  }
};

// Fetch paginated results
const getResults = async (page = 1) => {
  try {
    const response = await axios.get(`/api/allevents?page=${page}`);
    events.value = response.data;
  } catch (error) {
    console.error('Failed to fetch results:', error);
  }
};

// Methods for filtering events
const drafted = async () => {
  try {
    const response = await axios.get('/api/allevents?drafted=1');
    events.value = response.data;
    status.value = 'Drafted Events';
    draftedactive.value = true;
    liveactive.value = false;
    active.value = false;
    search.value = '';
  } catch (error) {
    console.error('Failed to filter drafted events:', error);
  }
};

const all = () => loadEvents();

const live = async () => {
  try {
    const response = await axios.get('/api/allevents?live=1');
    events.value = response.data;
    status.value = 'Live Events';
    active.value = false;
    draftedactive.value = false;
    liveactive.value = true;
    search.value = '';
  } catch (error) {
    console.error('Failed to filter live events:', error);
  }
};

// Delete methods
const destroy = async (slug) => {
  const result = await swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
  });

  if (result.isConfirmed) {
    try {
      await axios.get(`/events/${slug}/delete`);
      await swal.fire('Deleted!', 'Event has been deleted.', 'success');
      await loadEvents();
    } catch (error) {
      await swal.fire('Failed!', 'There was something wrong.', 'warning');
    }
  }
};

const draftDelete = async (slug) => {
  const result = await swal.fire({
    title: 'Are you sure?',
    text: "You won't see this event live!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, draft it!',
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/events/${slug}`);
      await swal.fire('Drafted!', 'Event has been drafted.', 'success');
      await loadEvents();
    } catch (error) {
      await swal.fire('Failed!', 'There was something wrong.', 'warning');
    }
  }
};

const draft = async (slug) => {
  const result = await swal.fire({
    title: 'Are you sure?',
    text: "You won't see this event live!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, draft it!',
  });

  if (result.isConfirmed) {
    try {
      await axios.delete(`/events/${slug}`);
      await swal.fire('Drafted!', 'Event has been drafted.', 'success');
      await loadEvents();
    } catch (error) {
      await swal.fire('Failed!', 'There was something wrong.', 'warning');
    }
  }
};

const unDraft = async (slug) => {
  const result = await swal.fire({
    title: 'Are you sure?',
    text: "You're going to make this event live!",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Make It Live!',
  });

  if (result.isConfirmed) {
    try {
      await axios.get(`/events/${slug}/undrafted`);
      await swal.fire('Undrafted!', 'Event is now live.', 'success');
      await loadEvents();
    } catch (error) {
      await swal.fire('Failed!', 'There was something wrong.', 'warning');
    }
  }
};

// Debounced search function
const debouncedSearch = _.debounce(async () => {
  try {
    const response = await axios.get(`/api/findAllEvents?q=${search.value}`);
    events.value = response.data;
  } catch (error) {
    console.error('Search failed:', error);
  }
}, 325);

// Watch for component mount
onMounted(() => {
  loadEvents();
  loadCount();
});

// Expose methods to template
const authorize = (role) => {
  // Implement your authorization logic here
  return true; // Placeholder for actual implementation
};

</script>
