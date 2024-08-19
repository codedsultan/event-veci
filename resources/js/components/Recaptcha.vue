<template>
    <div id="g-recaptcha" class="g-recaptcha" :data-sitekey="sitekey"></div>
  </template>
  <script setup>
  import { ref, onMounted } from 'vue';

  // Props
  const props = defineProps(['sitekey']);

  // Reactive data for widgetId
  const widgetId = ref(0);

  // Mounting the reCAPTCHA widget
  const setupRecaptcha = () => {
    if (window.grecaptcha) {
      widgetId.value = window.grecaptcha.render('g-recaptcha', {
        sitekey: props.sitekey
      });
    }
  };

  // Lifecycle hook to setup reCAPTCHA when the component is mounted
  onMounted(() => {
    setupRecaptcha();
  });
  </script>
