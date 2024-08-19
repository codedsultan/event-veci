<template>
    <div class="user-profile_img img-responsive">
      <img :src="avatar" alt="" @click="viewImage" class="img-responsive">
      <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
        <div class="fileUpload btn btn-avatar file">
          <label class="upload">
            <input name="avatar" type="file" accept="image/*" @change="onFileChange">
            <i class="fas fa-camera"></i> Update Image
          </label>
        </div>
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
