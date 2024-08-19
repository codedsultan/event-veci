<template>
    <div>
      <div name="EditProfile" height="auto" :scrollable="true" :adaptive="true">
        <div class="container mt-4">
          <h4 class="text-center">Edit Your Profile</h4>
          <form @submit.prevent="updateProfile">
            <div class="form-group">
              <label for="name" class="model-text"><b>Name:</b></label>
              <input
                type="text"
                class="form-control model-input"
                name="name"
                v-model="form.name"
                required
              />
              <span v-if="errors.name" class="text-danger">{{ errors.name[0] }}</span>
            </div>

            <div class="form-group">
              <label for="email" class="model-text"><b>Email:</b></label>
              <input
                type="email"
                class="form-control model-input"
                name="email"
                v-model="form.email"
                required
              />
              <span v-if="errors.email" class="text-danger">{{ errors.email[0] }}</span>
            </div>

            <div class="form-group">
              <label for="password" class="model-text"><b>Password:</b></label>
              <input
                type="password"
                class="form-control model-input"
                name="password"
                v-model="form.password"
              />
              <span v-if="errors.password" class="text-danger">{{ errors.password[0] }}</span>
            </div>

            <div class="form-group">
              <label for="profession" class="model-text"><b>Profession:</b></label>
              <input
                type="text"
                class="form-control model-input"
                name="profession"
                v-model="form.prof"
                placeholder="What You Do..."
              />
              <span v-if="errors.prof" class="text-danger">{{ errors.prof[0] }}</span>
            </div>

            <div class="form-group">
              <label for="about" class="model-text"><b>About:</b></label>
              <textarea
                name="about"
                class="form-control model-input"
                v-model="form.about"
                placeholder="Tell Something About YourSelf..."
                rows="4"
              ></textarea>
              <span v-if="errors.about" class="text-danger">{{ errors.about[0] }}</span>
            </div>

            <div class="form-group">
              <label for="backimg" class="model-text"><b>Background Image:</b></label>
              <input
                type="text"
                class="form-control model-input"
                name="backimg"
                v-model="form.backimg"
                placeholder="Add Your Background Url Here"
              />
              <span v-if="errors.backimg" class="text-danger">{{ errors.backimg[0] }}</span>
            </div>

            <div class="float-right mt-5 mb-5">
              <button type="submit" class="btn btn-success">Update Profile</button>
              <button
                type="button"
                class="btn btn-primary"
                @click.prevent="$modal.hide('EditProfile')"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
    </div>
    </div>
  </template>

<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
// import { useModal } from 'vue-js-modal'; // Ensure this is correctly imported
// import { useModal } from '@/composables/useModal'

// Props
const props = defineProps(['user']);

// Reactive state
const form = ref({
  name: props.user.name,
  email: props.user.email,
  password: props.user.password,
  prof: props.user.prof,
  about: props.user.about,
  backimg: props.user.backimg
});
const errors = ref({});

// Modal methods
// const { hide } = useModal();

// Update profile method
const updateProfile = async () => {
  try {
    await axios.patch(`/profile/${props.user.id}`, form.value);
    location.reload(); // Consider replacing with a more Vue-friendly state update
  } catch (error) {
    errors.value = error.response.data.errors;
  }
};

// Watch for changes in form values if needed (optional)
watch(form, (newForm) => {
  console.log('Form updated:', newForm);
}, { deep: true });
</script>

