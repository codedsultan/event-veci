<template>
    <div>
      <p class="single-event_detail-heading">
        About this event
        <span v-if="signedIn">
          <button
            v-if="button.active"
            class="btn follow-btn float-right"
            @click.prevent="unfollowEvent"
          >
            UnFollow Event
          </button>
          <button
            v-else
            class="btn header-btn float-right"
            @click.prevent="followEvent"
          >
            Follow Event
          </button>
        </span>
      </p>
    </div>
  </template>
  <script setup>
  import { ref, defineProps } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';

  // Define props
  const props = defineProps(['active']);

  // Reactive state for button
  const button = ref({
    active: props.active
  });

  // Method to follow an event
  const followEvent = async () => {
    try {
      await axios.post(`${location.pathname}/follow`);
      button.value.active = true;
      swal.fire('Success!', 'You are following the event.', 'success');
    } catch (error) {
      swal.fire('Warning!', 'Error! Please try again.', 'warning');
    }
  };

  // Method to unfollow an event
  const unfollowEvent = async () => {
    try {
      await axios.delete(`${location.pathname}/follow`);
      button.value.active = false;
      swal.fire('Info!', 'You have unfollowed the event.', 'info');
    } catch (error) {
      swal.fire('Warning!', 'Error! Please try again.', 'warning');
    }
  };

  // Computed or reactive property for signed-in state (if needed)
  // const signedIn = ref(true); // You may need to handle this based on your app logic

  </script>
