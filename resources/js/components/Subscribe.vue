<template>

<div class="flex justify-center px-2 my-[5%] bg-gray-900">
    <div class="mx-auto px-3 py-5 rounded-2xl md:px-8 md:py-7">
        <h4 class="text-2xl font-semibold tracking-wide text-white lg:text-3xl">Want more activities?</h4>
        <p class="max-w-xl mt-2 leading-relaxed text-blue-100 lg:text-lg">
            Sign up and get notified whenever new
            eventss get added to the collection.
        </p>
        <form @submit.prevent="subscribe">
        <div class="my-4 sm:flex sm:flex-row sm:justify-evenly">
            <input v-model="form.subscriber" class=" block w-full px-4 py-3 mt-3 text-gray-800 placeholder-gray-500 bg-white border border-gray-300 rounded-md appearance-none sm:max-w-xs focus:outline-none focus:ring focus:ring-blue-50 focus:border-blue-300" type="email" placeholder="Enter your email" value="">
            <button  type="submit" class="bg-blue-300 hover:bg-blue-200 block w-full py-3 mt-3 font-bold tracking-wide rounded shadow sm:ml-3 md:w-52 text-gray-900 focus">
                <span class="block ">Subscribe</span>
            </button>
        </div>
        </form>
    </div>
</div>
</template>

  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';

  // Define reactive form data
  const form = ref({
    subscriber: ''
  });

  // Define subscribe method
  const subscribe = async () => {
    // Check if the email field is not empty
    if (!form.value.subscriber) {
      swal.fire('Error!', 'Email address is required.', 'error');
      return;
    }

    try {
      // Post the subscription data
      await axios.post('/subscribe', { subscriber: form.value.subscriber });
      swal.fire('Success!', 'You have successfully subscribed to our newsletter.', 'success');
      // Clear the form field after successful subscription
      form.value.subscriber = '';
    } catch (error) {
      // Check for specific error response
      if (error.response && error.response.data && error.response.data.errors) {
        swal.fire('Error!', error.response.data.errors.subscriber[0], 'error');
      } else {
        // General error message if response data is not available
        swal.fire('Error!', 'An unexpected error occurred. Please try again later.', 'error');
      }
    }
  };
  </script>
