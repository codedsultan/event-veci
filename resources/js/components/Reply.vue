<template>

</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';

const props = defineProps(['reply']);
const body = ref(props.reply.body);
const form = ref({});
const submitted = ref(false);

// Method to show the modal
const show = () => {
  // Assuming $modal is available globally
  $modal.show(props.reply.id.toString());
};

// Method to hide the modal
const modalHide = () => {
  submitted.value = false;
  $modal.hide(props.reply.id.toString());
  body.value = props.reply.body;
};

// Method called when modal is closed
const closed = () => {
  // Set the opening time of the modal if needed
};

// Method to handle reply form submission
const replyForm = async () => {
  submitted.value = true;

  try {
    await axios.patch(`/replies/${props.reply.id}`, { body: body.value });
    await swal.fire("Success!", "Your reply added to discussion", "success");
    $modal.hide(props.reply.id.toString());
  } catch (error) {
    handleErrors(error);
  } finally {
    submitted.value = false;
  }
};

// Method to handle reply deletion
const destroy = async () => {
  try {
    await axios.delete(`/replies/${props.reply.id}`);
    await swal.fire("Success!", "Your reply deleted successfully", "success");
    $(this.$el).fadeOut(300);
  } catch (error) {
    await swal.fire("Warning!", "There is an error, please try again", "warning");
  }
};

// Method to handle discussion reply form submission
const discussionReplyForm = async () => {
  try {
    await axios.post(`/discussion/${props.reply.id}`, form.value);
    await swal.fire("Success!", "You successfully replied to the discussion", "success");
    window.location.reload();
  } catch (error) {
    console.log(error.response.data);
    await swal.fire('Error!', 'Please try again');
  }
};

// Method to handle errors
const handleErrors = (error) => {
  const errorData = error.response.data;
  console.log(errorData);
  if (errorData === "You are posting too frequently.") {
    swal.fire('You are updating too frequently');
  } else if (errorData.errors?.body?.[0] === 'The body field is required.') {
    swal.fire('The body field is required.');
  } else if (errorData.errors?.body?.[0] === 'validation.spamerror') {
    swal.fire('The reply contains spam');
  } else {
    swal.fire('Sorry! Please try again');
  }
};
</script>
