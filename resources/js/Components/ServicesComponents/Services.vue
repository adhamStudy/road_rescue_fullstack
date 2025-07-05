<template>
  <div>
    <!-- Header with toggle icon (shown only on mobile and md) -->
    <div class="w-full bg-blue-700 flex justify-between items-center px-6 py-8">
      <h1 class="text-2xl text-white">Our Services</h1>

      <!-- Icon only for mobile/md screens -->
      <button
        @click="showAll = !showAll"
        class="text-white lg:hidden transition-transform duration-300"
        aria-label="Toggle services"
      >
        <svg
          :class="[
            'w-6 h-6 transform transition-transform duration-300',
            showAll ? 'rotate-180' : 'rotate-0'
          ]"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </button>
    </div>

    <!-- Services section -->
    <Transition name="fade-slide">
      <div
        v-show="showAll || isDesktop"
        class="flex items-center justify-center px-4"
      >
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 w-full max-w-7xl py-6">
          <div v-for="n in 7" :key="n" class="mx-2">
            <ServiceCard />
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ServiceCard from './ServiceCard.vue'

const showAll = ref(false)
const isDesktop = ref(false)

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 1024 // lg breakpoint
  // Optional: reset showAll on desktop to avoid flicker
  if (isDesktop.value) showAll.value = false
}

onMounted(() => {
  handleResize()
  window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
