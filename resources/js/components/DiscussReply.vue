<template>
    <div :id="'reply-' + replys.id" class="bg-white p-4 rounded-lg shadow-md mb-4">
      <!-- User Information -->
      <div class="flex items-start mb-4">
        <a :href="`/profile/${replys.user.id}`" class="flex items-center space-x-2">
          <img :src="replys.user.gravatar" alt="User Avatar" class="w-10 h-10 rounded-full object-cover">
          <b class="text-blue-600">{{ replys.user.name }}</b>
        </a>
        <span class="ml-auto text-gray-500 text-sm">Replied at: <b>{{ formattedCreatedAt }}</b></span>
      </div>

      <!-- Reply Content -->
      <p class="mt-2 text-gray-700"><b>{{ replys.body }}</b></p>

      <!-- Action Buttons -->
      <div class="flex items-center justify-between mt-4">
        <!-- <div v-if="canEditOrDelete" class="space-x-2"> -->
        <div v-if="true" class="space-x-2">

          <EditReplyModal :reply="replys"/>
          <!-- <button @click="openEditModal" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">Edit</button> -->
          <button @click="deleteReply" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">Delete</button>
        </div>
        <div class="space-x-2">
          <!-- <button v-if="userIsAuthenticated" @click="openReplyModal" class="text-blue-500 hover:underline">Reply</button> -->
          <!-- <button v-if="true" @click="openReplyModal" class="text-blue-500 hover:underline">Reply</button> -->
          <!-- <EditReplyModal :reply="replys"  @close="showEditModal = false"/> -->
          <ReplyModal :reply="replys" />
          <!-- <button v-if="replys.discussionreplies.length > 0" @click="openAllRepliesModal" class="text-blue-500 hover:underline">View All Replies</button> -->
        </div>
      </div>


      <!-- <EditReplyModal :reply="replys" v-if="showEditModal" @close="showEditModal = false"/> -->
       <ReplyModal :reply="replys" v-if="showReplyModal" @close="showReplyModal = false"/>
       <!-- <AllReplies :reply="replys" v-if="showAllRepliesModal" @close="showAllRepliesModal = false"/> -->
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';
  import EditReplyModal from './EditReplyModal.vue';
  import ReplyModal from './ReplyModal.vue';
  import AllReplies from './AllReplies.vue';
//   import { useUser } from '@/composables/useUser'; // Custom composable for user authentication
//   import { usePermissions } from '@/composables/usePermissions'; // Custom composable for permissions

  // Props
  const props = defineProps({
    replys: Object
  });

//   console.log(reply.value)
  // Reactive state
  const showEditModal = ref(false);
  const showReplyModal = ref(false);
  const showAllRepliesModal = ref(false);
//   const user = useUser();
//   const permissions = usePermissions();

  // Computed properties
//   const canEditOrDelete = computed(() => permissions.can('update', props.reply));
//   const userIsAuthenticated = computed(() => user.isAuthenticated);
  const formattedCreatedAt = computed(() => new Date(props.replys.created_at).toLocaleString('en-US', { dateStyle: 'short', timeStyle: 'short' }));

  // Methods
  function openEditModal() {
    showEditModal.value = true;
  }

  function deleteReply() {
    // Implement delete logic here
  }

  function openReplyModal() {
    showReplyModal.value = true;
  }

  function openAllRepliesModal() {
    showAllRepliesModal.value = true;
    // Logic to open all replies modal
  }
  </script>

  <style scoped>
  /* Add any additional scoped styles if needed */
  </style>
