<template>
    <div v-if="authorize('isAdmin')">
      <p class="Dashboard-heading">Users</p>
      <p class="Dashboard-heading">Total Users:</p>
      <div class="form-group row">
        <div class="col-sm-4">
          <input
            type="text"
            class="form-control"
            id="user"
            v-model="search"
            placeholder="Search User"
            @keyup="searchIt"
          />
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">SrNo</th>
              <th scope="col">User Name</th>
              <th scope="col">Email Address</th>
              <th scope="col">Related Events</th>
              <th scope="col">Account Created At</th>
              <th scope="col">Option</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td><b>{{ user.id }}</b></td>
              <td>
                <a :href="'profile/' + user.id" class="text-user" target="_blank">
                  {{ user.name }}
                  <span v-if="user.isAdmin" class="badge badge-primary">Admin</span>
                </a>
              </td>
              <td>{{ user.email }}</td>
              <td class="text-center">{{ user.events.length }}</td>
              <td>{{ user.created_at | timeExactDate }}</td>
              <td>
                <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination :data="users" @pagination-change-page="getResults"></pagination>
    </div>
    <div v-else class="text-center mt-5">
      <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
      <a href="/" class="btn btn-primary mt-2">Go Back</a>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';
  import { debounce } from 'lodash';

  const users = ref({});
  const search = ref('');

  const authorize = (role) => {
    // Implement your authorization logic here
    return true; // Replace with actual authorization logic
  };

  const loadUsers = async () => {
    try {
      const { data } = await axios.get('/api/users');
      users.value = data;
    } catch (error) {
      console.error('Error loading users:', error);
    }
  };

  const deleteUser = async (id) => {
    const result = await swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
    });

    if (result.isConfirmed) {
      try {
        await axios.delete(`/api/users/${id}`);
        swal.fire('Deleted!', 'User has been deleted.', 'success');
        await loadUsers();
      } catch (error) {
        swal.fire('Failed!', 'There was something wrong.', 'warning');
      }
    }
  };

  const getResults = async (page = 1) => {
    try {
      const { data } = await axios.get(`/api/users?page=${page}`);
      users.value = data;
    } catch (error) {
      console.error('Error fetching paginated users:', error);
    }
  };

  // Debounce search function
  const searchIt = debounce(async () => {
    try {
      const { data } = await axios.get(`/api/findUsers?q=${search.value}`);
      users.value = data;
    } catch (error) {
      console.error('Error searching users:', error);
    }
  }, 325);

  onMounted(() => {
    loadUsers();
  });
  </script>
