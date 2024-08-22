<template>
    <BaseModal v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 overflow-auto bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-4 md:mx-0 p-6 relative">
        <!-- Close Button -->
        <button @click="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Modal Content -->
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <!-- Header Content -->
          <div class="flex items-center space-x-4">
            <img :src="reply.user.avatar_path" alt="User Avatar" class="w-16 h-16 rounded-full object-cover">
            <p class="text-lg font-semibold">
              Reply To <span class="text-blue-600">{{ reply.user.name }}</span>
            </p>
          </div>

          <!-- Textarea -->
          <textarea
            v-model="form.replybody"
            placeholder="Write your reply here..."
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
              Reply
            </button>
          </div>
        </form>
      </div>
    </BaseModal>
  </template>

  <script setup>
  import { ref, watch } from 'vue';
  import BaseModal from '@/Components/BaseModal.vue';
  // Props
  const props = defineProps({
    reply: Object,
    isModalOpen: Boolean
  });

  // Emits
  const emit = defineEmits(['update:isModalOpen', 'replyUpdated']);

  // Reactive state
  const form = ref({
    replybody: ''
  });
  const submitted = ref(false);

  // Watch for changes in reply prop
  watch(() => props.reply, (newReply) => {
    form.value.replybody = newReply?.body || '';
  });

  // Methods
  function closeModal() {
    emit('update:isModalOpen', false);
  }

  function handleSubmit() {
    submitted.value = true;
    // Simulate form submission
    setTimeout(() => {
      emit('replyUpdated', form.value.replybody); // Emit updated reply data
      submitted.value = false;
      closeModal();
    }, 1000);
  }
  </script>

  <style scoped>
  /* Add any additional scoped styles if needed */
  </style>
