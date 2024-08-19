<template>
    <div class="subscribe">
      <div class="subscribe-form">
        <p class="subscribe-form_para">Subscribe Our NewsLetter!</p>
        <form @submit.prevent="subscribe">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input
                  type="email"
                  class="form-control"
                  placeholder="Enter your email address"
                  v-model="form.subscriber"
                  name="subscriber"
                  required
                />
              </div>
            </div>
            <div class="col-md-12">
              <button type="submit" class="btn event-btn mb-5">Subscribe</button>
            </div>
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
      await axios.post('/subscribe', { email: form.value.subscriber });
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
