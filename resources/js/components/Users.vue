<template>
    <div v-if="authorize('isAdmin')">
    <!-- Heading Section -->
    <p class="text-2xl font-bold mb-4">Users</p>
    <p class="text-lg font-semibold mb-4">Total Users:</p>

    <!-- Search Input -->
    <div class="mb-6">
        <input
        type="text"
        class="form-input w-full sm:w-1/3 border-gray-300 rounded-md shadow-sm"
        id="user"
        v-model="search"
        placeholder="Search User"
        @keyup="searchIt"
        />
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
            <th scope="col" class="py-2 px-4 text-left">SrNo</th>
            <th scope="col" class="py-2 px-4 text-left">User Name</th>
            <th scope="col" class="py-2 px-4 text-left">Email Address</th>
            <th scope="col" class="py-2 px-4 text-center">Related Events</th>
            <th scope="col" class="py-2 px-4 text-left">Account Created At</th>
            <th scope="col" class="py-2 px-4 text-left">Option</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users.data" :key="user.id" class="border-b hover:bg-gray-100">
            <td class="py-2 px-4"><b>{{ user.id }}</b></td>
            <td class="py-2 px-4">
                <a :href="'profile/' + user.id" class="text-blue-500 hover:underline" target="_blank">
                {{ user.name }}
                <span v-if="user.isAdmin" class="ml-2 inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded">Admin</span>
                </a>
            </td>
            <td class="py-2 px-4">{{ user.email }}</td>
            <td class="py-2 px-4 text-center">{{ user.events.length }}</td>
            <td class="py-2 px-4">{{ user.created_at | timeExactDate }}</td>
            <td class="py-2 px-4">
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm" @click="deleteUser(user.id)">Delete</button>
            </td>
            </tr>
        </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <pagination :data="users" @pagination-change-page="getResults" class="mt-4"></pagination>
    </div>

    <!-- Non-Admin Access -->
    <div v-else class="text-center mt-16">
    <h2 class="text-2xl font-semibold mt-5">Only Admin Can Access Dashboard</h2>
    <a href="/" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">Go Back</a>
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
