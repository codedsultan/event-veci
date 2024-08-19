<script setup>
import { ref, onMounted } from 'vue';
import { Bar } from 'vue-chartjs';
import { defineComponent } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import axios from 'axios';

// Register the necessary Chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Define the chart component
const TicketSalesChart = defineComponent({
  name: 'TicketSalesChart',
  components: {
    Bar
  },
  setup() {
    // Reactive data
    const chartData = ref({
      labels: [],
      datasets: [
        {
          label: 'Ticket Sales Per Month',
          backgroundColor: '#2D395D',
          data: []
        }
      ]
    });

    // Fetch data and update chart
    const fetchTicketSales = async () => {
      try {
        const response = await axios.get('api/sales');
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
              label: 'Ticket Sales Per Month',
              backgroundColor: '#2D395D',
              data: totals
            }]
          };
        } else {
          console.log('No data');
        }
      } catch (error) {
        console.error('Failed to fetch ticket sales:', error);
      }
    };

    // Fetch data on component mount
    onMounted(() => {
      fetchTicketSales();
    });

    return {
      chartData
    };
  }
});

// export default TicketSalesChart;
</script>
