<template>
    <div>
      <Bar
        :data="chartData"
        :options="chartOptions"
        style="height: 400px; width: 600px;"
      />
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import { Bar } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
  import axios from 'axios';

  // Register Chart.js components
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

  // Reactive data for the chart
  const chartData = ref({
    labels: [],
    datasets: [{
      label: 'Ticket Sales Yearly',
      backgroundColor: '#2D395D',
      data: []
    }]
  });

  const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'top',
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            return `${context.dataset.label}: ${context.raw}`;
          }
        }
      }
    }
  });

  const fetchData = async () => {
    try {
      const { data } = await axios.get('api/yearsales');
      if (data) {
        const years = data.map(item => item.years);
        const totals = data.map(item => item.total);
        chartData.value.labels = years;
        chartData.value.datasets[0].data = totals;
      } else {
        console.log('No data');
      }
    } catch (error) {
      console.error('Error fetching sales data:', error);
    }
  };

  onMounted(() => {
    fetchData();
  });
  </script>
