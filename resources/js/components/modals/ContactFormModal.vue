<template>
    <div name="ContactForm" height="auto" scrollable :clickToClose="false">
        <form class="m-4" autocomplete="off" @keydown="submitted.value = false">
          <h3 class="text-center">Get In Contact With Event Organizer</h3>
          <div class="form-group">
            <label for="subject"><b>Enter Subject:</b></label>
            <input
              type="text"
              name="subject"
              v-model="form.subject"
              class="form-control"
              required
              placeholder="Subject"
              @keydown="deleteError('subject')"
            />
            <span v-if="errors.subject" class="text-danger text-small">{{ errors.subject[0] }}</span>
          </div>
          <div class="form-group">
            <label for="body"><b>Enter Your Message:</b></label>
            <textarea
              name="body"
              id=""
              cols="30"
              rows="10"
              v-model="form.body"
              class="form-control"
              placeholder="Message Content"
              required
              @keydown="deleteError('body')"
            ></textarea>
            <span v-if="errors.body" class="text-danger text-small">{{ errors.body[0] }}</span>
          </div>
          <p class="float-right">
            <span><button class="btn btn-danger" @click.prevent="hideModal">Close</button></span>
            <span><button class="btn btn-success" @click.prevent="submitForm" :disabled="submitted.value">Send</button></span>
          </p>
        </form>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';
// import { useModal } from '@/composables/useModal'
const props = defineProps(['event']);

const form = ref({});
const errors = ref({});
const submitted = ref(false);

// const { show: showModal, hide: hideModal } = useModal();

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



</script>
