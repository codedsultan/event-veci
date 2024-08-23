<template>
    <!-- <button v-if="true" @click="openModal" class="text-blue-500 hover:underline">Reply</button> -->
    <button v-if="true" @click="openModal" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Edit</button>
    <BaseModal
      :visible="showModal" @update:visible="showModal = $event"
    >
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- Header Content -->
        <div class="flex items-center space-x-4">
          <img
            src="https://i.ibb.co/0cdTjZ5/Capture.jpg"
            alt="Event"
            class="w-16 h-16 rounded-full object-cover"
          />
          <p class="text-lg font-semibold">
            Reply To <span class="text-blue-600">Event</span>
          </p>
        </div>

        <!-- Textarea -->
        <textarea
          v-model="body"
          placeholder="Write your reply..."
          rows="5"
          required
          class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        ></textarea>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
          <button
            type="button"
            @click="closeModal"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400"
          >
            Close
          </button>
          <button
            type="submit"
            :disabled="submitted"
            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400"
          >
            Update
          </button>
        </div>
      </form>
    </BaseModal>
  </template>

  <script setup>
  import { ref, watch } from 'vue';
  import BaseModal from '@/Components/BaseModal.vue';
// import { openModal } from 'jenesius-vue-modal';
  // Props
  const props = defineProps({
    reply: Object,
    isModalOpen: Boolean
  });

  // Emits
  const emit = defineEmits(['update:isModalOpen', 'updateReply']);
  const showModal = ref(false);
  // Reactive state
  const body = ref(props.reply?.body || '');
  const submitted = ref(false);

  // Watch for changes in reply prop
  watch(() => props.reply, (newReply) => {
    body.value = newReply?.body || '';
  });

  function openModal() {
    console.log('here')
    showModal.value = true;
  }
  // Methods
  function closeModal() {
    emit('update:isModalOpen', false);
  }

  function handleSubmit() {
    submitted.value = true;
    // Simulate form submission
    setTimeout(() => {
      emit('updateReply', body.value); // Emit updated reply data
      submitted.value = false;
      closeModal();
    }, 1000);
  }
  </script>

  <style scoped>
  /* Add any additional scoped styles if needed */
  </style>
