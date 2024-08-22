<template>
    <div>
      <button @click="showModal = true" class="px-4 py-2 bg-blue-500 text-white rounded">Attend Event</button>

      <base-modal :visible="showModal" @update:visible="showModal = $event" title="Purchase Event Ticket">
      <div>
    <!-- Display if quantity is available -->
    <div v-if="qty > 0" class="text-center p-6">
      <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-2xl font-semibold mb-4">{{ event.name }}</h4>
        <p class="text-lg mb-4"><b>Per Ticket Price: ${{ price }}</b></p>

        <div class="flex items-center justify-center space-x-4 mb-4">
          <button
            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 disabled:opacity-50"
            @click.prevent="decr"
            :disabled="selectedqty === 0"
          >
            -
          </button>
          <input
            type="text"
            name="selectedqty"
            v-model="selectedqty"
            readonly
            class="w-16 text-center border border-gray-300 rounded-md py-2"
          />
          <button
            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 disabled:opacity-50"
            @click.prevent="incr"
            :disabled="qty <= 0"
          >
            +
          </button>
        </div>

        <p class="text-lg mb-4"><b>Quantity Left: <span>{{ qty }}</span></b></p>
        <p class="text-lg mb-6"><b>Total Price: $<span>{{ selectedprice }}</span></b></p>

        <div class="bg-gray-50 p-4 rounded-md shadow-inner">
          <h4 class="text-xl font-semibold mb-4">Purchase Ticket</h4>
          <form class="space-y-4">
            <input type="hidden" name="stripeToken" v-model="stripeToken">
            <input type="hidden" name="stripeEmail" v-model="stripeEmail">
            <button
              class="px-6 py-2 bg-green-500 text-white rounded-md shadow-sm hover:bg-green-600 disabled:opacity-50"
              @click.prevent="buy"
              :disabled="selectedqty === 0"
            >
              Purchase
            </button>
          </form>
          <p class="text-sm text-gray-600 mt-2">*Policy: Purchased ticket cannot be refunded</p>
          <h3 class="text-green-500 mt-4" v-if="process">Hang on, your payment is in process</h3>
        </div>
      </div>
    </div>

    <!-- Display if quantity is not available -->
    <div v-else class="mt-6 p-6 bg-white rounded-lg shadow-md text-center">
      <h3 class="text-2xl font-semibold mb-2">Sorry! Event Ticket Sold Out</h3>
      <p class="text-lg text-gray-600"><b>*We will update event tickets if more quantity becomes available</b></p>
    </div>

    <!-- Close button -->
    <p class="text-right mt-4">
      <button
        class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600"
        @click="showModal = false"
      >
        Close
      </button>
    </p>
  </div>
      </base-modal>
    </div>
</template>
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import axios from 'axios';
  import swal from 'sweetalert2';
  import BaseModal from '@/Components/BaseModal.vue';
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
  const showModal = ref(false);
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
//   const showModal = () => {
//     // Function to show the modal
//     $modal.show('ticketModal');
//   };

//   const hideModal = () => {
//     // Function to hide the modal
//     $modal.hide('ticketModal');
//   };

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
    //integrate with backend
    stripe.open({
      name: props.event.name,
      description: `Purchased Ticket: ${selectedqty.value}`,
      amount: selectedprice.value * 100
    });
  };
  </script>
