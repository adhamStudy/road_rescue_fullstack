<template>
  <section class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('/assets/images/hero.jpg')"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-black/60 to-black/40"></div>
    
    <!-- Compact Glass Card Content -->
    <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
      <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl p-6 md:p-8 shadow-2xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-2">
        
        <!-- Main Title -->
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
          Smart RoadSide 
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
            Assistance
          </span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-base md:text-lg lg:text-xl text-gray-200 mb-6 max-w-2xl mx-auto leading-relaxed font-medium">
          On-the-spot Vehicle repairs through fully equipped mobile service Trucks
        </p>
        
        <!-- CTA Button -->
        <button 
          @click="requestHelp"
          class="group relative inline-flex items-center px-6 py-3 text-base font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-4 focus:ring-orange-300/50"
        >
          <span class="relative z-10">Request Help Now</span>
          <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" 
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
          </svg>
          
          <!-- Button Shine Effect -->
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 group-hover:translate-x-full transition-all duration-700 transform -skew-x-12"></div>
        </button>
        
        <!-- Decorative Elements -->
        <div class="absolute -top-3 -right-3 w-16 h-16 bg-gradient-to-br from-blue-400/30 to-purple-600/30 rounded-full blur-xl"></div>
        <div class="absolute -bottom-3 -left-3 w-12 h-12 bg-gradient-to-br from-orange-400/30 to-red-600/30 rounded-full blur-xl"></div>
      </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-2 h-2 bg-white/50 rounded-full animate-pulse"></div>
    <div class="absolute bottom-32 right-16 w-3 h-3 bg-blue-400/60 rounded-full animate-bounce"></div>
    <div class="absolute top-40 right-32 w-1 h-1 bg-orange-400/70 rounded-full animate-ping"></div>
  </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

const requestHelp = () => {
  // Handle the request help action
  router.visit('/request-service'); // Performs a GET request to the URL
  // You can add your logic here, like opening a modal or navigating to a contact form
}
</script>

<style scoped>
/* Custom shadow for enhanced glass effect */
.shadow-3xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
}

/* Enhanced backdrop blur for older browsers */
.backdrop-blur-xl {
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
}

/* Smooth animations */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.glass-card {
  animation: float 6s ease-in-out infinite;
}
</style>