<template>
  <div>
    <!-- Header with toggle icon (shown only on mobile and md) -->
    

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

const showAll = ref(true)
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
