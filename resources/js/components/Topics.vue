<template>
    <div v-if="authorize('isAdmin')">
      <p class="Dashboard-heading">
        Topics
        <button class="btn btn-light ml-2 btn-sm" @click="newModal"> +</button>
      </p>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">SrNo</th>
              <th scope="col">Name</th>
              <th scope="col">Created By</th>
              <th scope="col">Related Events</th>
              <th scope="col">Created At</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="topic in topics" :key="topic.id">
              <td><b>{{ topic.id }}</b></td>
              <td><a :href="'topic/' + topic.slug" class="text-user" target="_blank">{{ topic.name }}</a></td>
              <td>{{ topic.created_by }}</td>
              <td>{{ topic.events_count }}</td>
              <td>{{ topic.created_at | timeExactDate }}</td>
              <td>
                <button class="btn btn-sm btn-primary" @click="editModal(topic)">Edit</button>
                <button class="btn btn-sm btn-danger" @click="destroy(topic.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="modal fade" id="AddTopics" tabindex="-1" role="dialog" aria-labelledby="AddTopicLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="AddTopic" v-if="!editing">Create New Topic</h5>
              <h5 class="modal-title" id="AddTopic" v-if="editing">Update Topic</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="handleSubmit">
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" v-model="form.name" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <label for="image">Image:</label>
                  <input type="text" v-model="form.image" name="image" class="form-control" :class="{ 'is-invalid': form.errors.has('image') }">
                  <has-error :form="form" field="image"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" v-if="!editing">Create</button>
                <button type="submit" class="btn btn-primary" v-if="editing">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div v-else class="text-center mt-5">
      <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
      <a href="/" class="btn btn-primary mt-2">Go Back</a>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, reactive } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';
  import { useToast } from '@/composables/useToast'; // Import your toast composable if needed

  const topics = ref([]);
  const editing = ref(false);
  const form = reactive({
    id: '',
    name: '',
    image: '',
    errors: {
      has(field) {
        // Implement your error checking logic here
        return false;
      }
    }
  });

  const { success, error } = useToast(); // Assuming you have a toast composable

  // Authorization check
  const authorize = (role) => {
    // Implement your authorization logic here
    return true; // Replace with actual authorization logic
  };

  // Load topics
  const loadTopics = async () => {
    try {
      const { data } = await axios.get('/api/topics');
      topics.value = data;
    } catch (error) {
      console.error('Error loading topics:', error);
    }
  };

  // Show modal for new topic
  const newModal = () => {
    editing.value = false;
    $('#AddTopics').modal('show');
    Object.assign(form, { id: '', name: '', image: '' });
  };

  // Show modal for editing a topic
  const editModal = (topic) => {
    editing.value = true;
    $('#AddTopics').modal('show');
    Object.assign(form, topic);
  };

  // Handle form submission
  const handleSubmit = async () => {
    if (editing.value) {
      await updateTopic();
    } else {
      await createTopic();
    }
  };

  // Create a new topic
  const createTopic = async () => {
    try {
      await axios.post('/api/topics', form);
      success('Topic Created Successfully');
      $('#AddTopics').modal('hide');
      await loadTopics();
    } catch (error) {
      error('Error! Try Again');
    }
  };

  // Update an existing topic
  const updateTopic = async () => {
    try {
      await axios.patch(`/api/topics/${form.id}`, form);
      success('Topic Updated Successfully');
      $('#AddTopics').modal('hide');
      await loadTopics();
    } catch (error) {
      swal.fire('Error!', 'Please Try Again.', 'error');
    }
  };

  // Delete a topic
  const destroy = async (id) => {
    const result = await swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    });

    if (result.isConfirmed) {
      try {
        await axios.delete(`/api/topics/${id}`);
        success('Topic has been deleted.');
        await loadTopics();
      } catch (error) {
        error('There was something wrong.');
      }
    }
  };

  // Lifecycle hook
  onMounted(() => {
    loadTopics();
  });
  </script>
