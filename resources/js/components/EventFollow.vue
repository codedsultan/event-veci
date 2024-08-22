<template>
    <div class="py-2 bg-white">
    <p class="text-xl font-semibold text-gray-800 flex justify-between items-center">
        About this event
        <span v-if="true" class="ml-4">
        <!-- <span v-if="signedIn" class="ml-4"> -->
            <button
                v-if="button.active"
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                @click.prevent="UnFollow"
            >
                Unfollow Event
            </button>
            <button
                v-else
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                @click.prevent="Follow"
            >
                Follow Event
            </button>
        </span>
    </p>
</div>
    <!-- <div class="py-4 flex justify-between">
      <p class="text-left py-2">
        About this event
        </p>
        <div>
        <span  >
          <button
            v-if="button.active"
            class="px-6 py-2 min-w-[120px] text-center text-violet-600 border border-violet-600 rounded hover:bg-violet-600 hover:text-white active:bg-indigo-500 focus:outline-none focus:ring float-right"
            @click.prevent="unfollowEvent"
          >
            UnFollow Event
          </button>
          <button
            v-else
            class="px-6 py-2 min-w-[120px] text-center text-violet-600 border border-violet-600 rounded hover:bg-violet-600 hover:text-white active:bg-indigo-500 focus:outline-none focus:ring float-right"
            @click.prevent="followEvent"
          >
            Follow Event
          </button>
        </span>
        </div>
    </div> -->
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
