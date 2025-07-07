<!-- src/Layouts/HomeLayout.vue -->
<template>
  <div>
    <Header />

    <!-- Main content injected here -->
    <slot></slot>


  </div>
</template>

<script setup>
import Header from '../Components/Header.vue'
</script>
