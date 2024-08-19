<script setup>
import { ref, onMounted } from 'vue';
import { Line } from 'vue-chartjs';
import { defineComponent } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js';
import axios from 'axios';

// Register the necessary Chart.js components
ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale);

// Define the chart component
const TicketSalesChart = defineComponent({
  name: 'TicketSalesChart',
  components: {
    Line
  },
  setup() {
    // Reactive data for the chart
    const chartData = ref({
      labels: [],
      datasets: [
        {
          label: 'Revenue Generated Per Month',
          backgroundColor: '#2D395D',
          borderColor: '#2D395D',
          data: [],
          fill: false
        }
      ]
    });

    // Function to fetch data and update the chart
    const fetchRevenueData = async () => {
      try {
        const response = await axios.get('api/monthrevenue');
        const data = response.data;

        if (data) {
          const months = [];
          const totals = [];

          data.forEach(element => {
            months.push(element.months);
            totals.push(element.total);
          });

          chartData.value = {
            labels: months,
            datasets: [{
              label: 'Revenue Generated Per Month',
              backgroundColor: '#2D395D',
              borderColor: '#2D395D',
              data: totals,
              fill: false
            }]
          };
        } else {
          console.log('No data');
        }
      } catch (error) {
        console.error('Failed to fetch revenue data:', error);
      }
    };

    // Fetch data on component mount
    onMounted(() => {
      fetchRevenueData();
    });

    return {
      chartData
    };
  }
});

// export default TicketSalesChart;
</script>
