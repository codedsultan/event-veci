<template>
    <div>
      <div class="row">
        <div class="col-md-4">
          <img
            src="https://cdn.psychologytoday.com/sites/default/files/styles/article-inline-half-caption/public/field_blog_entry_images/2019-01/sadness-clipart-5.png?itok=YWtOFV4Z"
            alt="Error 404"
          />
        </div>
        <div class="col-md-8 text-center mt-5">
          <h1>Error 404</h1>
          <p>Sorry, page not found</p>
          <a href="/dashboard" class="btn btn-primary">Go Back</a>
        </div>
      </div>
    </div>
  </template>
  <script setup>
  import { onMounted } from 'vue';

  // Lifecycle hook to log message when component is mounted
  onMounted(() => {
    console.log('Component mounted.');
  });
  </script>
