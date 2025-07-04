<template>
  <div>
    <div class="bg-blue-100 p-2 mb-4 flex justify-between">
    <h1 class="w-fit font-semibold italic">My Company name</h1>
    <div>
      <ul class="flex space-x-3 mr-10 text-sm">
        <li class="hover:text-bold transition hover:text-blue-500 hover:cursor-pointer">
          <a href="/">Home</a>
        </li>
        <li class="hover:text-bold transition hover:text-blue-500 hover:cursor-pointer">
          About
        </li>
        
      </ul>
    </div>
  </div>
  <Hero/>
  </div>

  <!-- Hero Section -->

</template>

<script setup>

import Hero from '../Components/Hero.vue';

</script>
