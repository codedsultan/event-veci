<template>
  <div>
    <div class="card">
      <!-- Default panel contents -->
      <div class="card-header bg-success text-center text-white">
        <h5><i>Recent Activities</i></h5>
      </div>

      <ul class="list-group feed">
        <li v-if="!feeds.length">No activities available</li>
        <li class="list-group-item" v-for="feed in feeds" :key="feed.id">
          <a :href="'/profile/' + feed.user.id" target="_blank">
            <img :src="feed.user.profile" alt="" class="feed-img" />
            {{ feed.user.name }}
          </a>
          {{ feed.description }}
          <a :href="feed.link" target="_blank">{{ feed.title }}</a>
          <span class="pull-right ml-2">
            <i><b>{{ feed.lapse }}</b></i>
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onBeforeMount } from 'vue';
import axios from 'axios';
import Echo from 'laravel-echo'; // Assuming you're using Laravel Echo

export default {
  setup() {
    const feeds = ref([]);

    const getFeed = async () => {
      try {
        const response = await axios.get('/api/activities');
        feeds.value = response.data.data;
      } catch (error) {
        console.error('Error fetching feeds:', error);
      }
    };

    const listenForActivity = () => {
      Echo.channel('activity')
        .listen('ActivityLogged', (e) => {
          feeds.value.unshift(e);
        });
    };

    onBeforeMount(() => {
      getFeed();
      listenForActivity();
    });

    onMounted(() => {
      console.log('Component mounted.');
    });

    return {
      feeds
    };
  }
};
</script>

<style scoped>
/* Add component-specific styles here */
</style>
