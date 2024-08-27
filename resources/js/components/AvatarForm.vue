<template>
    <div class="user-profile-img relative w-40 h-40 mx-auto mt-4">
      <!-- User Avatar -->
      <img
        :src="avatar"
        alt="User Avatar"
        @click="viewImage"
        class="w-full h-full object-cover rounded-full cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition-all duration-300"
      />

      <!-- Upload Form -->
      <form v-if="canUpdate" method="POST" enctype="multipart/form-data" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full opacity-0 hover:opacity-100 transition-opacity duration-300">
        <label class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full cursor-pointer hover:bg-blue-600">
          <input
            name="avatar"
            type="file"
            accept="image/*"
            @change="onFileChange"
            class="hidden"
          />
          <i class="fas fa-camera"></i>
        </label>
      </form>
    </div>
  </template>

  <script setup>
  import { ref, computed } from 'vue';
  import axios from 'axios';
//   import { useToast } from 'vue-toastification'; // Import your toast library
  import { useToast } from '@/composables/useToast';

  // Define props
  const props = defineProps({
    user: {
      type: Object,
      required: true
    }
  });

  const avatar = ref(props.user.profile);
  const avatarPath = ref(props.user.avatar_path);

  const toast = useToast(); // Initialize toast

  // Computed property to determine if the user can update the avatar
  const canUpdate = computed(() => {
    // Replace with your actual authorization logic
    return true
    // /* replace with current user id or auth check */ === props.user.id;
  });

  // Method to view the image
  const viewImage = () => {
    window.open(avatarPath.value);
  };

  // Method to handle file input change
  const onFileChange = (e) => {
    if (!e.target.files.length) return;

    const file = e.target.files[0];
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = (event) => {
      avatar.value = event.target.result;
    };

    persist(file);
  };

  // Method to persist the file upload
  const persist = (file) => {
    const data = new FormData();
    data.append('avatar', file);

    // Example: Start the progress bar
    // this.$Progress.start(); // Adapt as needed

    axios.post(`/api/profile/${props.user.id}/avatar`, data)
      .then(() => {
        // Example: Finish the progress bar
        // this.$Progress.finish(); // Adapt as needed
        toast.success('Avatar Uploaded Successfully');
      })
      .catch(() => {
        // Example: Fail the progress bar
        // this.$Progress.fail(); // Adapt as needed
        toast.error('Error! Try Again');
      });
  };
  </script>

  <style scoped>
  /* Add component-specific styles here */
  </style>
