<template>
    <div>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Panel Header -->
        <div class="bg-green-500 text-center text-white py-4">
        <h5 class="text-lg font-semibold italic"><i>Recent Activities</i></h5>
        </div>

        <!-- Activity Feed List -->
        <ul class="divide-y divide-gray-200">
        <li v-if="!feeds.length" class="p-4 text-center text-gray-500">
            No activities available
        </li>
        <li class="p-4 flex items-center" v-for="feed in feeds" :key="feed.id">
            <!-- User Profile Link -->
            <a :href="'/profile/' + feed.user.id" target="_blank" class="flex-shrink-0">
            <img :src="feed.user.profile" alt="User profile image" class="w-12 h-12 rounded-full object-cover mr-4" />
            </a>
            <div class="flex-grow">
            <!-- Feed Description -->
            <a :href="'/profile/' + feed.user.id" target="_blank" class="font-medium text-gray-900 hover:underline">
                {{ feed.user.name }}
            </a>
            <span class="text-gray-600">{{ feed.description }}</span>
            <!-- Feed Title Link -->
            <a :href="feed.link" target="_blank" class="text-blue-500 hover:underline ml-1">{{ feed.title }}</a>
            </div>
            <!-- Time Lapse -->
            <span class="ml-4 text-gray-500">
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
