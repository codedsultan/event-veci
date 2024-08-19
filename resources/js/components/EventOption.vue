<template>
    <div>
      <span>
        <a class="btn btn-link" :href="`/events/${event.slug}/edit`">Edit</a>
      </span>
      <span v-if="event.deleted_at">
        <a href="#" class="btn btn-link" @click.prevent="handleUnDraft">Undraft</a>
      </span>
      <span v-else>
        <a href="#" class="btn btn-link" @click.prevent="handleDraft">Draft</a>
      </span>
      <span v-if="event.deleted_at">
        <a href="#" class="btn btn-link" @click.prevent="handleDraftDelete">Delete</a>
      </span>
      <span v-else>
        <a href="#" class="btn btn-link" @click.prevent="handleDeleteEvent">Delete</a>
      </span>
    </div>
  </template>
  <script setup>
  import { ref, watchEffect } from 'vue';
  import axios from 'axios';
  import Swal from 'sweetalert2';

  // Props definition
  const props = defineProps(['event']);
  const event = ref(props.event);

  // Watch props to reactively update event data
  watchEffect(() => {
    event.value = props.event;
  });

  // Utility function for displaying alerts
  const showAlert = async (title, text, icon, confirmButtonText, successMessage, redirectUrl = null) => {
    const result = await Swal.fire({
      title,
      text,
      icon,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText
    });

    if (result.isConfirmed) {
      try {
        // Action will be executed here
        if (redirectUrl) window.location.href = redirectUrl;
        await Swal.fire(successMessage, '', 'success');
        window.location.reload();
      } catch (error) {
        await Swal.fire('Failed!', 'There was something wrong.', 'warning');
      }
    }
  };

  // Handler functions
  const handleDeleteEvent = () => showAlert(
    'Are you sure?',
    "You won't be able to revert this!",
    'warning',
    'Yes, delete it!',
    'Event has been deleted.'
  );

  const handleDraft = () => showAlert(
    'Are you sure?',
    "You won't see this event live!",
    'warning',
    'Yes, draft it!',
    'Event has been drafted.'
  );

  const handleDraftDelete = () => showAlert(
    'Are you sure?',
    "You won't be able to revert this!",
    'warning',
    'Yes, delete it!',
    'Event has been deleted.'
  );

  const handleUnDraft = () => showAlert(
    'Are you sure?',
    "You're going to make this event live!",
    'info',
    'Yes, undraft it!',
    'Event has gone live.',
    '/myevents'
  );
  </script>
