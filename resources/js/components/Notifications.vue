<template>
    <div>
      <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span><i class="far fa-bell"></i></span>
        <span class="notification-alert" v-if="notifications.length"></span>
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">
          <a class="dropdown-item" :href="notification.data.link" @click.prevent="markAsRead(notification)">
            <img :src="notification.data.notifier.avatar"
                 :alt="notification.data.notifier.username" class="notifications-img">
            <span v-html="notification.data.message"></span>
          </a>
        </li>
        <li v-if="!notifications.length" class="dropdown-item">
          You have no new notifications
        </li>
      </div>
    </div>
  </template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Reactive data for notifications
const notifications = ref([]);

// Fetch notifications from the API
const fetchNotifications = async () => {
  try {
    const response = await axios.get(`/profile/${window.App.user.id}/notifications`);
    notifications.value = response.data;
  } catch (error) {
    console.error('Failed to fetch notifications:', error);
  }
};

// Mark a notification as read
const markAsRead = async (notification) => {
  try {
    const response = await axios.delete(`/profile/${window.App.user.id}/notifications/${notification.id}`);
    fetchNotifications(); // Refresh notifications list
    window.location.replace(response.data.link); // Redirect to the notification link
  } catch (error) {
    console.error('Failed to mark notification as read:', error);
  }
};

// Fetch notifications when the component is mounted
onMounted(() => {
  fetchNotifications();
});
</script>
