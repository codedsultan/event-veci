<template>
    <div>
      <a class="btn event-btn" @click="showModal">Add Discussion</a>
      <modal class="model-design animated slideInUp" :class="{'SlideInDown': !isRed}" name="reply-modal"
        height="auto"
        width="60%"
        :pivotY="1"
        :clickToClose="false"
        transition="ease"
        @closed="onClosed">
        <form class="reply-form" autocomplete="off" @keydown="submitted = false">
          <p>
            <img src="https://i.ibb.co/0cdTjZ5/Capture.jpg" alt="">
            <span class="reply-form_heading">Reply To <span class="reply-form_heading_Event">Event</span></span>
          </p>
          <div class="form-group">
            <textarea name="body" id="" cols="30" rows="5" required v-model="form.body" class="form-control reply-textarea"></textarea>
          </div>
          <p class="float-right">
            <span><button class="btn btn-danger" @click.prevent="modalHide">Close</button></span>
            <span><button class="btn btn-success" @click.prevent="replyForm" :disabled="submitted">Submit</button></span>
          </p>
        </form>
      </modal>
    </div>
  </template>

<script setup>
import { ref, defineProps } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';

const props = defineProps(['event']);

// Reactive state
const isRed = ref(true);
const form = ref({});
const errors = ref({});
const submitted = ref(false);

// Method to show modal
const showModal = () => {
  // This assumes $modal is available globally
  $modal.show('reply-modal');
};

// Method to hide modal
const modalHide = () => {
  isRed.value = false;
  submitted.value = false;
  $modal.hide('reply-modal');
  form.value = {};
};

// Method called when modal is closed
const onClosed = () => {
  isRed.value = false;
};

// Method to handle form submission
const replyForm = async () => {
  submitted.value = true;

  try {
    const response = await axios.post(`/events/${props.event.slug}/replies`, form.value);
    await swal.fire("Success!", "Your reply added to discussion", "success");
    location.href = response.data.message;
    $modal.hide('reply-modal');
  } catch (error) {
    errors.value = error.response.data;
    console.log(error.response.data);

    if (error.response.data === "You are posting too frequently.") {
      await swal.fire('You are posting too frequently');
    } else if (error.response.data.errors?.body?.[0] === 'The body field is required.') {
      await swal.fire('The body field is required.');
      console.log(error.response.data.errors.body[0]);
    } else if (error.response.data.errors?.body?.[0] === 'validation.spamerror') {
      await swal.fire('The reply contains spam');
    } else {
      await swal.fire('Sorry! Please Try Again');
    }
  } finally {
    submitted.value = false;
  }
};
</script>
