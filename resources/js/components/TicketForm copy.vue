<template>
    <div>
      <p><button class="btn event-btn float-right" @click="showModal">Attend Event</button></p>

      <modal name="ticketModal" height="auto" width="60%" :click-to-close="false" transition="ease" :adaptive="true">
        <div class="row" v-if="qty > 0">
          <div class="col-md-7">
            <form class="reply-form">
              <h4>{{ event.name }}</h4>
              <p><b>Per Ticket Price: ${{ price }}</b></p>
              <p>
                <span><b>Select Quantity:</b></span>
                <br>
                <button class="btn btn-primary btn-sm" @click.prevent="decr" :disabled="selectedqty === 0">-</button>
                <button class="btn btn-primary btn-sm" @click.prevent="decr" v-show="selectedqty > 0">-</button>
                <input type="text" name="selectedqty" v-model="selectedqty" readonly class="text-center ticket-input">
                <button class="btn btn-primary btn-sm" @click.prevent="incr" :disabled="qty <= 0">+</button>
                <button class="btn btn-primary btn-sm" @click.prevent="incr" v-show="qty > 0">+</button>
              </p>
              <p><b>Quantity Left: <span>{{ qty }}</span></b></p>
              <p><b>Total Price: $<span>{{ selectedprice }}</span></b></p>
            </form>
          </div>
          <div class="col-md-5">
            <h4 class="mt-5 mb-3">Purchase Ticket</h4>
            <form class="mb-3">
              <input type="hidden" name="stripeToken" v-model="stripeToken">
              <input type="hidden" name="stripeEmail" v-model="stripeEmail">
              <button class="btn btn-sm btn-success" @click.prevent="buy" :disabled="selectedqty === 0"><b>Purchase</b></button>
            </form>
            <p>*Policy: Purchased ticket cannot be refunded</p>
            <h3 class="text-success" v-show="process">Hang on, your payment is in process</h3>
          </div>
        </div>
        <div v-else class="mt-5 mb-5 ml-5">
          <h3>Sorry! Event Ticket Sold Out</h3>
          <p><b>*We will update event tickets if more quantity becomes available</b></p>
        </div>
        <p class="float-right mr-3">
          <button class="btn btn-danger" @click.prevent="hideModal">Close</button>
        </p>
      </modal>
    </div>
  </template>

  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';

  // Props
  const props = defineProps({
    event: Object
  });

  // Reactive state
  const price = ref(props.event.price);
  const qty = ref(props.event.qty);
  const selectedqty = ref(0);
  const selectedprice = ref(0);
  const stripeEmail = ref('');
  const stripeToken = ref('');
  const process = ref(false);

  // Stripe configuration
  let stripe;

  onMounted(() => {
    stripe = StripeCheckout.configure({
      key: "pk_test_WtlPYx4DSs5vXZ9yFINdZDru00iWLlEhjQ",
      image: "https://cdn1.medicalnewstoday.com/content/images/hero/284/284378/284378_1100.jpg",
      locale: "auto",
      token: (token) => {
        stripeToken.value = token.id;
        stripeEmail.value = token.email;
        process.value = true;
        axios.post(`/buy/${props.event.slug}`, {
          price: price.value,
          qty: qty.value,
          selectedqty: selectedqty.value,
          selectedprice: selectedprice.value,
          stripeToken: stripeToken.value,
          stripeEmail: stripeEmail.value
        })
          .then(() => {
            swal.fire("Success!", "You successfully purchased the event ticket", "success");
            hideModal();
            process.value = false;
            selectedqty.value = 0;
            selectedprice.value = 0;
          })
          .catch((error) => {
            swal.fire({
              icon: 'error',
              title: 'Payment Failed',
              text: 'Something went wrong!',
              footer: '<a href="mailto:hamza_pisces@live.com">Contact Us</a>'
            });
            hideModal();
            process.value = false;
            selectedqty.value = 0;
            selectedprice.value = 0;
            qty.value = props.event.qty;
          });
      }
    });
  });

  // Methods
  const showModal = () => {
    // Function to show the modal
    $modal.show('ticketModal');
  };

  const hideModal = () => {
    // Function to hide the modal
    $modal.hide('ticketModal');
  };

  const incr = () => {
    if (qty.value > 0) {
      selectedqty.value++;
      qty.value--;
      selectedprice.value += price.value;
    }
  };

  const decr = () => {
    if (selectedqty.value > 0) {
      selectedqty.value--;
      qty.value++;
      selectedprice.value -= price.value;
    }
  };

  const buy = () => {
    stripe.open({
      name: props.event.name,
      description: `Purchased Ticket: ${selectedqty.value}`,
      amount: selectedprice.value * 100
    });
  };
  </script>
