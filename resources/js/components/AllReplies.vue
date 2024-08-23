<template>
    <BaseModal
      v-if="isModalOpen"
      @close="closeModal"
      class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-lg"
      :width="'80%'"
      :height="'auto'"
      scrollable
    >
      <div class="discussion-replies space-y-4">
        <!-- Main Discussion Summary -->
        <p class="text-lg font-semibold">
          {{ truncatedBody }}
          <span class="text-gray-600">
            (This Discussion Contains {{ reply.discussionreplies.length }} Replies)
          </span>
        </p>

        <!-- Replies List -->
        <div v-for="discussionReply in reply.discussionreplies" :key="discussionReply.id" class="mb-4">
          <DiscussionReply :reply="discussionReply" :user="discussionReply.user" />
          <hr class="my-4 border-gray-200" />
        </div>
      </div>
    </BaseModal>
  </template>

  <script setup>
  import { computed } from 'vue';
  import BaseModal from '@/Components/BaseModal.vue'; // Adjust the import path as needed
  import DiscussionReply from '@/Components/DiscussionReply.vue'; // Adjust the import path as needed

  // Props
  const props = defineProps({
    reply: Object,
    isModalOpen: Boolean
  });

  // Emits
  const emit = defineEmits(['update:isModalOpen']);

  // Computed properties
  const truncatedBody = computed(() => {
    return props.reply.body.length > 200
      ? props.reply.body.substring(0, 200) + '...'
      : props.reply.body;
  });

  // Methods
  function closeModal() {
    emit('update:isModalOpen', false);
  }
  </script>

  <style scoped>
  /* Scoped styles if needed */
  </style>
