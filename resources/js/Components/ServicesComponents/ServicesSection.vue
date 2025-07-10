<!-- ServiceSection.vue -->
<template>
  <div class="services-container">
    <!-- Floating background elements -->
    <div class="floating-elements">
      <div class="floating-element"></div>
      <div class="floating-element"></div>
      <div class="floating-element"></div>
    </div>

    <!-- Services section - Always visible -->
    <Transition name="fade-slide">
      <div class="flex items-center justify-center px-4 relative z-10">
        <div class="grid grid-cols-1 gap-6 sm:gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 w-full max-w-8xl py-8 sm:py-12">
          <div 
            v-for="(service, index) in services" 
            :key="service.id" 
            class="service-item w-full max-w-sm mx-auto"
            :style="{ '--delay': index * 0.1 + 's' }"
          >
            <ServiceCard :service="service" />
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ServiceCard from './ServiceCard.vue'

defineProps({
  services: {
    type: Array,
    required: true
  }
});

const showAll = ref(true)
const isDesktop = ref(false)

const handleResize = () => {
  isDesktop.value = window.innerWidth >= 1024 // lg breakpoint
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
.services-container {
  position: relative;
  background: linear-gradient(135deg, #f0f0f0 0%, #8d8991 100%);
  min-height: 100vh;
  overflow: hidden;
}

.services-container::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 80%, rgba(227, 227, 249, 0.3) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(215, 211, 213, 0.3) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(215, 216, 216, 0.2) 0%, transparent 50%);
  animation: aurora 8s ease-in-out infinite alternate;
}

@keyframes aurora {
  0% { opacity: 0.5; }
  100% { opacity: 1; }
}

.floating-elements {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

.floating-element {
  position: absolute;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  animation: float-around 20s ease-in-out infinite;
}

.floating-element:nth-child(1) {
  width: 100px;
  height: 100px;
  top: 10%;
  left: 10%;
  animation-delay: 0s;
}

.floating-element:nth-child(2) {
  width: 120px;
  height: 120px;
  top: 15%;
  right: 10%;
  animation-delay: -7s;
}

.floating-element:nth-child(3) {
  width: 60px;
  height: 60px;
  bottom: 25%;
  left: 15%;
  animation-delay: -14s;
}

@keyframes float-around {
  0%, 100% { 
    transform: translateY(0px) translateX(0px) rotate(0deg); 
  }
  25% { 
    transform: translateY(-20px) translateX(15px) rotate(90deg); 
  }
  50% { 
    transform: translateY(-5px) translateX(-15px) rotate(180deg); 
  }
  75% { 
    transform: translateY(15px) translateX(8px) rotate(270deg); 
  }
}

.service-item {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.6s ease-out forwards;
  animation-delay: var(--delay);
}

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-15px) scale(0.98);
}

/* Responsive Design */
@media (max-width: 640px) {
  .services-container {
    min-height: auto;
    padding: 1rem 0;
  }
  
  .floating-element {
    opacity: 0.3;
  }
  
  .floating-element:nth-child(1) {
    width: 60px;
    height: 60px;
  }
  
  .floating-element:nth-child(2) {
    width: 80px;
    height: 80px;
  }
  
  .floating-element:nth-child(3) {
    width: 40px;
    height: 40px;
  }
}

@media (min-width: 641px) and (max-width: 1024px) {
  .services-container {
    padding: 2rem 0;
  }
}

@media (min-width: 1025px) {
  .services-container {
    padding: 4rem 0;
  }
}
</style>