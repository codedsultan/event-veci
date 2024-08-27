<template>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75" @click="showModal">Edit Profile</button>
    <BaseModal :title="'Edit Profile'" :visible="isModalOpen" @update:visible="isModalOpen = $event">
        <form @submit.prevent="updateProfile">
      <!-- Name Field -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
        <input
          type="text"
          id="name"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.name"
          required
        />
        <span class="text-red-500 text-sm" v-if="errors.name" v-text="errors.name[0]"></span>
      </div>

      <!-- Email Field -->
      <div class="mb-4">
        <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
        <input
          type="email"
          id="email"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.email"
          required
        />
        <span class="text-red-500 text-sm" v-if="errors.email" v-text="errors.email[0]"></span>
      </div>

      <!-- Password Field -->
      <div class="mb-4">
        <label for="password" class="block text-gray-700 font-bold mb-2">Password:</label>
        <input
          type="password"
          id="password"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.password"
        />
        <span class="text-red-500 text-sm" v-if="errors.password" v-text="errors.password[0]"></span>
      </div>

      <!-- Profession Field -->
      <div class="mb-4">
        <label for="profession" class="block text-gray-700 font-bold mb-2">Profession:</label>
        <input
          type="text"
          id="profession"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.prof"
          placeholder="What You Do..."
        />
        <span class="text-red-500 text-sm" v-if="errors.prof" v-text="errors.prof[0]"></span>
      </div>

      <!-- About Field -->
      <div class="mb-4">
        <label for="about" class="block text-gray-700 font-bold mb-2">About:</label>
        <textarea
          id="about"
          rows="4"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.about"
          placeholder="Tell Something About Yourself..."
        ></textarea>
        <span class="text-red-500 text-sm" v-if="errors.about" v-text="errors.about[0]"></span>
      </div>

      <!-- Background Image Field -->
      <div class="mb-4">
        <label for="backimg" class="block text-gray-700 font-bold mb-2">Background Image:</label>
        <input
          type="text"
          id="backimg"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          v-model="form.backimg"
          placeholder="Add Your Background URL Here"
        />
        <span class="text-red-500 text-sm" v-if="errors.backimg" v-text="errors.backimg[0]"></span>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end mt-6">
        <button class="bg-green-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-green-600" type="submit">Update Profile</button>
        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" type="button" @click="$emit('cancel')">Cancel</button>
      </div>
    </form>
    </BaseModal>
  </template>

  <script setup>
  import { ref ,reactive} from 'vue';
  import BaseModal from '@/Components/BaseModal.vue';

  const props = defineProps({
    user: {
      type: Object,
      required: true,
    },
    visible: {
      type: Boolean,
      default: false,
    },
  });
  const errors = ref({});
  const emit = defineEmits(['update:visible', 'update:user']);

  const form = reactive({
  name: props.user.name,
  email: props.user.email,
  password: '',
  prof: props.user.prof || '',
  about: props.user.about || '',
  backimg: props.user.backimg || '',
});

const isModalOpen = ref(false);
//   const isVisible = ref(props.visible);
    function showModal() {
        console.log('here');
        isModalOpen.value = true;
    }

    function closeModal() {
        isModalOpen.value = false;
    }
    function handleVisibility(value) {
        isVisible.value = value;
    }

    function updateProfile() {
        // Add logic to handle profile update
    // Example: API call to update profile
    // On success, clear the form or show a success message
    // On failure, populate errors object with the received errors

        emit('update:user', form.value);
        emit('update:visible', false);
    }
  </script>

  <style scoped>
  /* Add any additional styling specific to the EditProfile component here */
  </style>
