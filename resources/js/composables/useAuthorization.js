// src/composables/useUser.js
import { ref } from 'vue';

export function useAuthorization() {
  // Assume window.App.user is globally available
  const user = ref(window.App.user);

  function updateDiscussionReply(reply) {
    return reply.user_id === user.value.id;
  }

  function isAdmin() {
    return user.value.isAdmin;
  }

  return {
    updateDiscussionReply,
    isAdmin
  };
}



