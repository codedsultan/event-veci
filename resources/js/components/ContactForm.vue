<template>
    <div>
      <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded">Contact Event Organizer</button>

      <base-modal name="ContactForm" height="auto" :visible="showModal" @update:visible="showModal = $event">
      <form class="m-6 p-6 max-w-lg mx-auto bg-white shadow-lg rounded-lg" autocomplete="off" @keydown="submitted = false">
  <h3 class="text-2xl font-semibold text-center mb-6">Get In Contact With Event Organizer</h3>

  <div class="mb-4">
    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
      <b>Enter Subject:</b>
    </label>
    <input
      type="text"
      name="subject"
      v-model="form.subject"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
      required
      placeholder="Subject"
      @keydown="deleteError('subject')"
    />
    <span v-if="errors.subject" class="text-red-500 text-sm mt-1 block">{{ errors.subject[0] }}</span>
  </div>

  <div class="mb-6">
    <label for="body" class="block text-sm font-medium text-gray-700 mb-1">
      <b>Enter Your Message:</b>
    </label>
    <textarea
      name="body"
      id="body"
      cols="30"
      rows="6"
      v-model="form.body"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
      placeholder="Message Content"
      required
      @keydown="deleteError('body')"
    ></textarea>
    <span v-if="errors.body" class="text-red-500 text-sm mt-1 block">{{ errors.body[0] }}</span>
  </div>

  <div class="flex justify-end">
    <!-- <button class="bg-red-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500" @click.prevent="hideModal">Close</button> -->
    <button class="bg-green-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500" @click.prevent="submitForm" :disabled="submitted">
      Send
    </button>
  </div>
</form>
      </base-modal>
    </div>
  </template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';
// import { useModal } from 'vue-js-modal'; // Adjust import if necessary
import { useModal } from '@/composables/useModal'
import ContactFormModal from '@/components/modals/ContactFormModal.vue'
const props = defineProps(['event']);
const showModal = ref(false);
const form = ref({});
const errors = ref({});
const submitted = ref(false);

const { openModal, close } = useModal();

const submitForm = async () => {
  submitted.value = true;
  try {
    const response = await axios.post(`/mail/${props.event.slug}`, form.value);
    swal.fire('Success!', 'Mail Sent Successfully!', 'success');
    hideModal('ContactForm');
    form.value = {};
  } catch (error) {
    errors.value = error.response.data.errors;
    swal.fire('Error!', 'Failed to send mail. Please try again.', 'error');
  } finally {
    submitted.value = false;
  }
};

const deleteError = (field) => {
  delete errors.value[field];
};

// const showModal = () => {
//   openModal(ContactFormModal,props);
// //   show('ContactForm');
// };

// const hideModal = () => {
// //   useModal().hide('ContactForm');
//   close(ContactFormModal);
// };

</script>
