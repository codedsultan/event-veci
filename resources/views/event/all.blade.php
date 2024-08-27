@include('header')
<header class="relative bg-cover bg-center bg-fixed" data-type="background" data-speed="7">
  <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white py-24">
    <h1 class="text-4xl md:text-5xl font-bold tracking-wide">
      <span class="block text-lg md:text-xl text-gray-300 mb-2">View All Events</span>
    </h1>
    <p class="max-w-lg text-base md:text-lg text-gray-200 mb-6">
      Join a local group to meet people, try something new, or do more of what you love
    </p>
    <a href="/create-event" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition duration-300">
      Create An Event
    </a>
  </div>
</header>

<div class="container mx-auto mt-12" id="app">
  <p class="text-2xl font-bold mb-4">All Events</p>
  <events></events>
</div>

@include('footer')
