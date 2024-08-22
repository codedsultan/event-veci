<template>
    <div class="max-w-3xl">
      <div
        class="transition-all duration-200 cursor-pointer"
      >
        <button
          @click="toggle()"
          class="flex items-center justify-between w-34"
        >
          <span class="flex  text-black"><slot name="title"></slot></span>
          <svg
            :class="{'rotate-180': activeIndex}"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            class="w-6 h-6 text-gray-400 transition-transform duration-300"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <transition name="fade">
          <div
            v-if="activeIndex"
            class="py-2"
          >
            <slot name="content"></slot>
            <!-- <p>{{ item.answer }}</p> -->
          </div>
        </transition>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  const props = defineProps(['items']);
//   const items = [
//     { id: 1, question: 'How can I get started?', answer: 'Getting started is easy! Sign up for an account, and you\'ll have access to our platform\'s features. No credit card required for the initial signup.' },
//     { id: 2, question: 'What is the pricing structure?', answer: 'Our pricing structure is flexible. We offer both free and paid plans. You can choose the one that suits your needs and budget.' },
//     { id: 3, question: 'What kind of support do you provide?', answer: 'We offer comprehensive customer support. You can reach out to our support team through various channels, including email, chat, and a knowledge base.' },
//     { id: 4, question: 'Can I cancel my subscription anytime?', answer: 'Yes, you can cancel your subscription at any time without any hidden fees. We believe in providing a hassle-free experience for our users.' }
//   ];

  const activeIndex = ref(false);

  function toggle() {

    activeIndex.value = !activeIndex.value;
  }
  </script>

  <style scoped>
  .rotate-180 {
    transform: rotate(180deg);
  }
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  </style>
