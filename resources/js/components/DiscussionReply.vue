<template>
    <div>
      <p>
        <a :href="`/profile/${user.id}`">
          <img :src="user.avatar_path" alt="" />
          {{ user.name }}
        </a>
      </p>
      <span v-if="editing">
        <textarea
          class="form-control mt-3"
          v-model="replybody"
        ></textarea>
        <button class="btn btn-link btn-sm" @click="update">Update</button>
        <button class="btn btn-link btn-sm" @click="editing = false">Close</button>
      </span>
      <span v-else class="discussion-replies_body">{{ replybody }}</span>
      <span v-if="authorize('updateDiscussionReply', reply)">
        <br />
        <button class="btn btn-primary btn-sm" @click="editing = true">
          <i class="far fa-edit"></i>
        </button>
        <button class="btn btn-danger btn-sm" @click.prevent="destroy">
          <i class="far fa-trash-alt"></i>
        </button>
      </span>
    </div>
  </template>
  <script setup>
  import { ref, watch } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';
  import { useAuthorization } from '@/composables/useAuthorization'; // Import your custom authorization hook

  // Props
  const props = defineProps({
    reply: Object,
    user: Object
  });

  // State
  const editing = ref(false);
  const replybody = ref(props.reply.replybody);

  // Authorization
  const { authorize } = useAuthorization();

  // Methods
  const update = async () => {
    try {
      await axios.patch(`/discussionreply/${props.reply.id}`, { replybody: replybody.value });
      swal.fire('Success!', 'You successfully updated the discussion reply', 'success');
      editing.value = false;
    } catch (error) {
      console.log(error.response?.data);
      swal.fire('Error!', 'Please try again', 'error');
      replybody.value = props.reply.replybody; // Revert changes on error
    }
  };

  const destroy = async () => {
    try {
      await axios.delete(`/discussionreply/${props.reply.id}`);
      swal.fire('Success!', 'Your discussion reply was deleted successfully', 'success');
      window.location.reload(); // Consider using a more Vue-friendly approach for reloading the component
    } catch (error) {
      swal.fire('Warning!', 'There was an error, please try again', 'warning');
    }
  };

  // Watch for changes in the reply prop to update local state
  watch(() => props.reply.replybody, (newValue) => {
    replybody.value = newValue;
  });
  </script>
