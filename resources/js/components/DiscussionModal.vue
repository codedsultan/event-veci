<template>
    <div>
      <!-- Add Discussion Button -->
      <button
        class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"
        @click="showModal"
      >
        Add Discussion
      </button>

      <!-- Modal Component -->
      <BaseModal :visible="isModalOpen" @update:visible="isModalOpen = $event" title="Reply To Event">
        <!-- <template #header>
          <h2 class="text-xl font-semibold text-gray-800">Reply To Event</h2>
        </template> -->

        <!-- <template #body> -->
          <div class="flex flex-col items-center">
            <img src="https://i.ibb.co/0cdTjZ5/Capture.jpg" alt="Event" class="w-full h-48 object-cover rounded-lg mb-4">
            <p class="text-lg font-semibold text-gray-700 mb-4">Reply To <span class="text-blue-600">Event</span></p>
            <form class="w-full max-w-lg" @submit.prevent="handleSubmit">
              <textarea
                v-model="form.body"
                required
                rows="5"
                placeholder="Write your reply..."
                class="w-full p-3 border rounded-lg border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
              ></textarea>
              <div class="flex justify-end space-x-4 mt-4">
                <button
                  type="button"
                  class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
                  @click="closeModal"
                >
                  Close
                </button>
                <button
                  type="submit"
                  class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400"
                  :disabled="submitted"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        <!-- </template> -->
      </BaseModal>
    </div>
  </template>


<script setup>
import { ref } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';
import BaseModal from '@/Components/BaseModal.vue'; // Adjust path as needed

const isModalOpen = ref(false);
const form = ref({
  body: ''
});
const submitted = ref(false);
// const showModal = ref(false);
function showModal() {
    console.log('here');
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
}
const props = defineProps(['event']);

// Reactive state
const isRed = ref(true);
// const form = ref({});
const errors = ref({});


// Method called when modal is closed
// const onClosed = () => {
//   isRed.value = false;
// };

// Method to handle form submission
const handleSubmit = async () => {
  submitted.value = true;

  try {
    const response = await axios.post(`/events/${props.event.slug}/replies`, form.value);
    await swal.fire("Success!", "Your reply added to discussion", "success");
    location.href = response.data.message;
    closeModal();
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
