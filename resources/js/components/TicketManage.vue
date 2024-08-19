<template>
    <div>
      <div v-if="authorize('isAdmin')">
        <p class="Dashboard-heading">Purchased Ticket</p>
        <p class="Dashboard-heading">Total Receipt: {{ count }}</p>
        <p class="Dashboard-heading float-right">Receipt Delivered: {{ delivered }}</p>
        <p class="Dashboard-heading">Status: {{ status }}</p>

        <div class="form-group">
          <div class="col-sm-4">
            <input
              type="text"
              class="form-control"
              id="ticket"
              v-model="search"
              placeholder="Search Ticket By Receipt"
              @keyup="searchIt"
            />
          </div>
        </div>

        <div class="dropdown float-right">
          <button
            class="btn btn-primary dropdown-toggle"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Select Ticket Option
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#" @click="all">
              <span v-if="active" class="text-primary"><i class="far fa-check-circle"></i> <b>All Tickets</b></span>
              <span v-else>All Tickets</span>
            </a>
            <a class="dropdown-item" href="#" @click="deliver">
              <span v-if="deliveractive" class="text-primary"><i class="far fa-check-circle"></i> <b>Delivered Tickets</b></span>
              <span v-else>Delivered Tickets</span>
            </a>
            <a class="dropdown-item" href="#" @click="undeliver">
              <span v-if="undeliveractive" class="text-primary"><i class="far fa-check-circle"></i> <b>Undelivered Tickets</b></span>
              <span v-else>Undelivered Tickets</span>
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Receipt Number</th>
                <th scope="col">Purchased By</th>
                <th scope="col">Customer Email</th>
                <th scope="col">Event Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Purchased Date</th>
                <th scope="col">Status</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in tickets.data" :key="ticket.id">
                <td>{{ ticket.receipt }}</td>
                <td><a :href="'profile/' + ticket.user.id" class="text-user" target="_blank">{{ ticket.user.name }}</a></td>
                <td>{{ ticket.user.email }}</td>
                <td><a :href="'events/' + ticket.event.slug" class="text-user" target="_blank">{{ ticket.event.name }}</a></td>
                <td class="text-center">{{ ticket.qty }}</td>
                <td>${{ ticket.total }}</td>
                <td>{{ ticket.created_at | timeExactDate }}</td>
                <td v-if="ticket.delivered === 0">
                  <button class="btn btn-primary btn-sm" @click="deliverTicket(ticket.id)">Send</button>
                </td>
                <td v-else>
                  <span class="btn btn-success btn-sm" disabled>Delivered</span>
                </td>
                <td>
                  <button class="btn btn-danger btn-sm" @click="deleteTicket(ticket.id)">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <pagination :data="tickets" @pagination-change-page="getResults"></pagination>
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
  import _ from 'lodash';
  import { useModal } from '@/composables/useModal'; // Import your modal composable if needed

  // Props and reactive state
  const tickets = ref({});
  const count = ref({});
  const delivered = ref({});
  const status = ref('');
  const search = ref('');
  const active = ref(false);
  const deliveractive = ref(false);
  const undeliveractive = ref(false);

  // Authorization check
  const authorize = (role) => {
    // Implement your authorization logic here
    return true; // Replace with actual authorization logic
  };

  // Functions
  const loadTickets = () => {
    axios.get('/api/tickets')
      .then(({ data }) => {
        tickets.value = data;
        active.value = true;
        deliveractive.value = false;
        undeliveractive.value = false;
        status.value = "All Tickets";
      });
  };

  const ticketsCount = () => {
    axios.get('/api/ticketscount')
      .then(({ data }) => {
        count.value = data;
      });
  };

  const ticketsDelivered = () => {
    axios.get('/api/ticketsdelivered')
      .then(({ data }) => {
        delivered.value = data;
      });
  };

  const all = () => {
    loadTickets();
  };

  const deliver = () => {
    axios.get('/api/tickets?deliver=1')
      .then(({ data }) => {
        tickets.value = data;
        active.value = false;
        deliveractive.value = true;
        undeliveractive.value = false;
        status.value = "Delivered Tickets";
      });
  };

  const undeliver = () => {
    axios.get('/api/tickets?undeliver=1')
      .then(({ data }) => {
        tickets.value = data;
        active.value = false;
        deliveractive.value = false;
        undeliveractive.value = true;
        status.value = "Undelivered Tickets";
      });
  };

  const deleteTicket = (id) => {
    swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`/api/ticket/${id}`)
          .then(() => {
            swal.fire('Deleted!', 'Ticket Receipt has been deleted.', 'success');
            loadTickets();
            ticketsCount();
          })
          .catch(() => {
            swal.fire('Failed!', 'There was something wrong.', 'warning');
          });
      }
    });
  };

  const deliverTicket = (id) => {
    swal.fire({
      title: 'Are you sure?',
      text: "You are sending tickets to the customer!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, send it!'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.post(`/api/ticket/deliver/${id}`)
          .then(() => {
            swal.fire('Sent!', 'Ticket has been sent successfully.', 'success');
            loadTickets();
            ticketsDelivered();
          })
          .catch(() => {
            swal.fire('Failed!', 'There was something wrong.', 'warning');
          });
      }
    });
  };

  const getResults = (page = 1) => {
    axios.get(`/api/tickets?page=${page}`)
      .then(response => {
        tickets.value = response.data;
      });
  };

  // Debounced search
  const searchIt = _.debounce(() => {
    Fire.$emit('searching');
  }, 325);

  // Search event handler
  Fire.$on('searching', () => {
    axios.get(`/api/findtickets?q=${search.value}`)
      .then(({ data }) => {
        tickets.value = data;
      });
  });

  // Lifecycle hooks
  onMounted(() => {
    loadTickets();
    ticketsCount();
    ticketsDelivered();
  });
  </script>
