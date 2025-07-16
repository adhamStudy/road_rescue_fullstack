<template>
  <div>
    <Header />

     <!-- Flash Message -->
        <div
            v-if="$page.props.flash.success"
            class="bg-green-100 text-black text-sm border border-green-200 rounded-lg p-2 m-5 dark:bg-green-900 dark:text-white dark:border-green-700"
        >
            {{ $page.props.flash.success }}
        </div>
        <div
            v-if="$page.props.flash.error"
            class="bg-red-100 animate-bounce text-black text-sm border text-center border-red-200 rounded-lg p-2 m-5 dark:bg-red-900 dark:text-white dark:border-red-700"
        >
            {{ $page.props.flash.error }}
        </div>

    <!-- Main content injected here -->
    <slot></slot>
    <Footer/>
  </div>
</template>

<script setup>
import Header from '../Components/Header.vue'
import Footer from '../Components/Footer.vue'

import { ref, computed, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const isOpen = ref(false);

</script>