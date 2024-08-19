<template>
    <div>
      <div v-if="authorize('isAdmin')">
        <p class="Dashboard-heading">DashBoard</p>
        <div class="info">
          <div class="row">
            <div class="col-md-3 text-center col-sm-6" v-for="(item, index) in infoItems" :key="index">
              <div class="row info-row">
                <div class="col-sm-9 info-right">
                  <span class="info-right_name">{{ item.title }}</span>
                  <span class="info-right_name">{{ item.subtitle }}</span>
                  <br>
                  <span class="info-right_count">{{ item.count }}</span>
                  <br>
                  <span class="info-right_name">This Month</span>
                  <span class="float-right">
                    <b>{{ item.monthCount }}</b>
                    <span class="float-right ml-2" :class="{'active': item.ratio > 0, 'shake': item.ratio < 0}">
                      {{ item.ratio }}%
                      <i :class="{'fas fa-arrow-up': item.ratio > 0, 'fas fa-arrow-down': item.ratio < 0}"></i>
                    </span>
                  </span>
                </div>
                <div class="col-sm-3 info-left">
                  <i :class="item.iconClass" class="info-left_icon"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 col-lg-6">
            <div v-if="ticketChart">
              <span class="float-right">
                <button class="btn btn-primary btn-sm" disabled>Month</button>
                <button class="btn-primary btn btn-sm" @click="toggleChart('ticketChart', false)">Year</button>
              </span>
              <div class="float-left">
                <MonthChart />
              </div>
            </div>
            <div v-else>
              <span class="float-right">
                <button class="btn btn-primary btn-sm" @click="toggleChart('ticketChart', true)">Month</button>
                <button class="btn-primary btn btn-sm" disabled>Year</button>
              </span>
              <div class="float-left">
                <YearChart />
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-6">
            <div v-if="salesChart">
              <span class="float-right">
                <button class="btn btn-primary btn-sm" disabled>Month</button>
                <button class="btn-primary btn btn-sm" @click="toggleChart('salesChart', false)">Year</button>
              </span>
              <div class="float-left">
                <MonthSaleChart />
              </div>
            </div>
            <div v-else>
              <span class="float-right">
                <button class="btn btn-primary btn-sm" @click="toggleChart('salesChart', true)">Month</button>
                <button class="btn-primary btn btn-sm" disabled>Year</button>
              </span>
              <div class="float-left">
                <YearSaleChart />
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12">
            <ActivityFeed />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mt-4">
            <p class="dashboard-para">
              "DreamEvent is a Laravel Vue.js based Event Application built for portfolio purpose. You can find its source code on <a href="https://github.com/hamza094/Dream" target="_blank">GitHub</a>. Built by <a href="https://hikportfolio.herokuapp.com/" target="_blank">Hamza Ikram</a> &copy; 2020 All Rights Reserved!"
            </p>
          </div>
        </div>
      </div>
      <div v-else class="text-center mt-5">
        <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
        <a href="/" class="btn btn-primary mt-2">Go Back</a>
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
