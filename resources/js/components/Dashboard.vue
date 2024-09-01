<template>
    <div>
        <div v-if="authorize('isAdmin')">
            <p class="text-2xl font-semibold mb-4">Dashboard</p>

            <div class="info">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full sm:w-1/2 md:w-1/4 px-4 mb-4 text-center" v-for="(item, index) in infoItems" :key="index">
                <div class="flex bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="w-3/4 p-4 text-left">
                    <span class="block font-semibold text-lg">{{ item.title }}</span>
                    <span class="block text-gray-500">{{ item.subtitle }}</span>
                    <br>
                    <span class="block text-2xl font-bold">{{ item.count }}</span>
                    <br>
                    <span class="block text-sm">This Month</span>
                    <span class="float-right">
                        <b>{{ item.monthCount }}</b>
                        <span class="ml-2" :class="{'text-green-500': item.ratio > 0, 'text-red-500 animate-shake': item.ratio < 0}">
                        {{ item.ratio }}%
                        <i :class="{'fas fa-arrow-up': item.ratio > 0, 'fas fa-arrow-down': item.ratio < 0}"></i>
                        </span>
                    </span>
                    </div>
                    <div class="w-1/4 bg-gray-100 flex items-center justify-center p-4">
                    <i :class="item.iconClass" class="text-3xl"></i>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Charts -->
            <div class="flex flex-wrap -mx-4 mt-8">
            <div class="w-full lg:w-1/2 px-4 mb-8">
                <div v-if="ticketChart">
                <div class="flex justify-end mb-2">
                    <button class="btn btn-primary btn-sm mr-2" disabled>Month</button>
                    <button class="btn btn-primary btn-sm" @click="toggleChart('ticketChart', false)">Year</button>
                </div>
                <MonthChart />
                </div>
                <div v-else>
                <div class="flex justify-end mb-2">
                    <button class="btn btn-primary btn-sm mr-2" @click="toggleChart('ticketChart', true)">Month</button>
                    <button class="btn btn-primary btn-sm" disabled>Year</button>
                </div>
                <YearChart />
                </div>
            </div>

            <div class="w-full lg:w-1/2 px-4 mb-8">
                <div v-if="salesChart">
                <div class="flex justify-end mb-2">
                    <button class="btn btn-primary btn-sm mr-2" disabled>Month</button>
                    <button class="btn btn-primary btn-sm" @click="toggleChart('salesChart', false)">Year</button>
                </div>
                <MonthSaleChart />
                </div>
                <div v-else>
                <div class="flex justify-end mb-2">
                    <button class="btn btn-primary btn-sm mr-2" @click="toggleChart('salesChart', true)">Month</button>
                    <button class="btn btn-primary btn-sm" disabled>Year</button>
                </div>
                <YearSaleChart />
                </div>
            </div>
            </div>

            <!-- Activity Feed -->
            <div class="mt-8">
            <ActivityFeed />
            </div>

            <!-- Information Section -->
            <div class="mt-8">
            <p class="text-center text-gray-600">
                "DreamEvent is a Laravel Vue.js based Event Application built for portfolio purpose. You can find its source code on
                <a href="https://github.com/hamza094/Dream" target="_blank" class="text-blue-500 underline">GitHub</a>. Built by
                <a href="https://hikportfolio.herokuapp.com/" target="_blank" class="text-blue-500 underline">Hamza Ikram</a> &copy; 2020 All Rights Reserved!"
            </p>
            </div>
        </div>

    <!-- Non-Admin Access -->
        <div v-else class="text-center mt-16">
            <h2 class="text-2xl font-semibold mt-5">Only Admin Can Access Dashboard</h2>
            <a href="/" class="btn btn-primary mt-4">Go Back</a>
        </div>
    </div>
  </template>
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';
  import { useAuthorization } from '@/composables/useAuthorization'; // Custom hook for authorization
  import MonthChart from '@/Components/MonthChart.vue';
  import YearChart from '@/Components/YearChart.vue';
  import MonthSaleChart from '@/Components/MonthSaleChart.vue';
  import YearSaleChart from '@/Components/YearSaleChart.vue';
  import ActivityFeed from '@/Components/ActivityFeed.vue';

  // Props
  const props = defineProps({
    event: Object
  });

  // State
  const userRatio = ref(0);
  const usersCount = ref(0);
  const userMonth = ref(0);
  const eventsRatio = ref(0);
  const eventsCount = ref(0);
  const eventsMonth = ref(0);
  const topicsCount = ref(0);
  const subscribeCount = ref(0);
  const ticketsCount = ref(0);
  const ticketsMonth = ref(0);
  const ticketsRatio = ref(0);
  const ticketChart = ref(true);
  const salesChart = ref(true);

  // Authorization
  const { authorize } = useAuthorization();

  // Fetch Data
  const fetchData = async () => {
    try {
      const [{ data: userCountData }, { data: userRatioData }, { data: userMonthData },
             { data: eventRatioData }, { data: eventCountData }, { data: eventMonthData },
             { data: topicCountData }, { data: subscribeCountData }, { data: ticketCountData },
             { data: ticketMonthData }, { data: ticketRatioData }] = await Promise.all([
        axios.get('/api/dashboard?users=true'),
        axios.get('/api/dashboard?userRatio=true'),
        axios.get('/api/dashboard?monthUser=true'),
        axios.get('/api/dashboard?eventRatio=true'),
        axios.get('/api/dashboard?events=true'),
        axios.get('/api/dashboard?monthEvent=true'),
        axios.get('/api/dashboard?topics=true'),
        axios.get('/api/dashboard?subscribe=true'),
        axios.get('/api/dashboard?tickets=true'),
        axios.get('/api/dashboard?ticketMonth=true'),
        axios.get('/api/dashboard?ticketRatio=true'),
      ]);

      usersCount.value = userCountData;
      userRatio.value = userRatioData;
      userMonth.value = userMonthData;
      eventsRatio.value = eventRatioData;
      eventsCount.value = eventCountData;
      eventsMonth.value = eventMonthData;
      topicsCount.value = topicCountData;
      subscribeCount.value = subscribeCountData;
      ticketsCount.value = ticketCountData;
      ticketsMonth.value = ticketMonthData;
      ticketsRatio.value = ticketRatioData;
    } catch (error) {
      swal.fire('Error!', 'Failed to fetch data. Please try again.', 'error');
    }
  };

  // Toggle chart visibility
  const toggleChart = (chartType, visibility) => {
    if (chartType === 'ticketChart') {
      ticketChart.value = visibility;
    } else if (chartType === 'salesChart') {
      salesChart.value = visibility;
    }
  };

  // Component Lifecycle Hook
  onMounted(() => {
    fetchData();
  });
  </script>
