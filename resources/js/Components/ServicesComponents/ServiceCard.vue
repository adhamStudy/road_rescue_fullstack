<template>
  <div class="service-card group" @click="handleCardClick">
    <!-- Glowing border effect -->
    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 rounded-2xl sm:rounded-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 blur-xl"></div>
    
    <div class="relative bg-white/95 backdrop-blur-xl rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl sm:shadow-2xl border border-white/20 h-full flex flex-col">
      <!-- Header with dynamic gradient -->
      <div class="service-header" :class="getServiceClass(service.name)">
        <div class="absolute inset-0 bg-gradient-to-br opacity-90"></div>
        <div class="absolute inset-0 bg-black/10"></div>
        
        <!-- Animated background pattern -->
        <div class="absolute inset-0 opacity-20">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 animate-shimmer"></div>
        </div>
        
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
          <div class="service-icon text-4xl sm:text-5xl lg:text-6xl mb-2 sm:mb-4 animate-float">
            {{ getServiceIcon(service.name) }}
          </div>
          <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white tracking-tight leading-tight">
            {{ service.name }}
          </h2>
          <div class="w-12 sm:w-16 h-0.5 sm:h-1 bg-white/30 rounded-full mt-2 sm:mt-3"></div>
        </div>
        
        <!-- Pulse effect -->
        <div class="absolute inset-0 rounded-t-2xl sm:rounded-t-3xl opacity-0 group-hover:opacity-30 transition-opacity duration-300">
          <div class="absolute inset-0 bg-white animate-pulse"></div>
        </div>
      </div>

      <!-- Body content -->
      <div class="service-body flex-1 p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
        <!-- Service description -->
        <div class="space-y-3 sm:space-y-4">
          <div class="flex items-center gap-2 sm:gap-3">
            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full animate-pulse"></div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 truncate">{{ service.name }}</h3>
          </div>
          
          <p class="text-gray-600 leading-relaxed text-sm sm:text-base line-clamp-3">
            {{ service.description }}
          </p>
        </div>

        <!-- Features tags -->
        <div class="flex flex-wrap gap-1.5 sm:gap-2">
          <span 
            v-for="feature in getServiceFeatures(service.name)" 
            :key="feature"
            class="px-2 sm:px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 text-xs font-medium rounded-full border border-blue-200/50 whitespace-nowrap"
          >
            {{ feature }}
          </span>
        </div>

        <!-- Response time -->
        <div class="flex items-center gap-2 sm:gap-3 text-gray-500 text-sm">
          <div class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex-shrink-0">
            <span class="text-white text-xs font-bold">⚡</span>
          </div>
          <div class="flex flex-col min-w-0">
            <span class="font-medium text-gray-700 text-xs sm:text-sm">Response Time</span>
            <span class="text-xs text-gray-500 truncate">{{ getResponseTime(service.name) }}</span>
          </div>
        </div>

        <!-- CTA Button -->
        <button class="emergency-btn w-full mt-auto">
          <span class="relative z-10 flex items-center justify-center gap-2">
            <span class="text-base sm:text-lg">🚨</span>
            <span class="font-semibold text-sm sm:text-base truncate">Request {{ service.name }}</span>
          </span>
          <div class="btn-glow"></div>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  service: {
    type: Object,
    required: true
  }
});

const handleCardClick = () => {
  // Add click feedback
  const card = event.currentTarget;
  card.style.transform = 'scale(0.98)';
  setTimeout(() => {
    card.style.transform = '';
  }, 150);
}

const getServiceClass = (name) => {
  const classes = {
    'Medical Emergency': 'medical-gradient',
    'Police Emergency': 'police-gradient', 
    'Fire Emergency': 'fire-gradient',
    'Roadside Assistance': 'roadside-gradient'
  };
  return classes[name] || 'default-gradient';
}

const getServiceIcon = (name) => {
  const icons = {
    'Medical Emergency': '🚑',
    'Police Emergency': '🚓',
    'Fire Emergency': '🚒', 
    'Roadside Assistance': '🔧'
  };
  return icons[name] || '🆘';
}

const getServiceFeatures = (name) => {
  const features = {
    'Medical Emergency': ['24/7 Available', 'Certified EMTs', 'Life Support'],
    'Police Emergency': ['Rapid Response', 'Crime Prevention', 'Public Safety'],
    'Fire Emergency': ['Fire Suppression', 'Rescue Ops', 'Hazmat'],
    'Roadside Assistance': ['Towing', 'Jump Start', 'Tire Change']
  };
  return features[name] || ['Professional', 'Reliable', 'Fast'];
}

const getResponseTime = (name) => {
  const times = {
    'Medical Emergency': 'Avg 4-8 minutes',
    'Police Emergency': 'Avg 3-7 minutes', 
    'Fire Emergency': 'Avg 5-10 minutes',
    'Roadside Assistance': 'Avg 15-30 minutes'
  };
  return times[name] || 'Contact for details';
}
</script>

<style scoped>
.service-card {
  position: relative;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  height: 100%;
  min-height: 420px;
}

.service-card:hover {
  transform: translateY(-4px) scale(1.01);
}

.service-header {
  height: 140px;
  position: relative;
  overflow: hidden;
}

/* Service-specific gradients */
.medical-gradient {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 50%, #ff8a80 100%);
}

.police-gradient {
  background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 50%, #26c6da 100%);
}

.fire-gradient {
  background: linear-gradient(135deg, #ffa726 0%, #fb8c00 50%, #ffcc02 100%);
}

.roadside-gradient {
  background: linear-gradient(135deg, #ab47bc 0%, #8e24aa 50%, #ba68c8 100%);
}

.default-gradient {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

@keyframes shimmer {
  0% { transform: translateX(-100%) skewX(-12deg); }
  100% { transform: translateX(200%) skewX(-12deg); }
}

.animate-shimmer {
  animation: shimmer 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-8px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.emergency-btn {
  position: relative;
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
  color: white;
  padding: 12px 20px;
  border-radius: 12px;
  border: none;
  font-size: 0.9rem;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
  min-height: 48px;
}

.emergency-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
}

.emergency-btn:active {
  transform: translateY(0px);
}

.btn-glow {
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: left 0.5s ease;
}

.emergency-btn:hover .btn-glow {
  left: 100%;
}

.service-body {
  background: rgba(255, 255, 255, 0.98);
}

.line-clamp-3 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 3;
}

/* Mobile Responsive Design */
@media (max-width: 640px) {
  .service-card {
    min-height: 380px;
    transform: none !important;
  }
  
  .service-card:hover {
    transform: translateY(-2px) scale(1.005) !important;
  }
  
  .service-header {
    height: 120px;
  }
  
  .emergency-btn {
    padding: 14px 18px;
    font-size: 0.875rem;
    min-height: 44px;
  }
}

@media (min-width: 641px) and (max-width: 768px) {
  .service-card {
    min-height: 400px;
  }
  
  .service-header {
    height: 130px;
  }
  
  .emergency-btn {
    padding: 13px 19px;
    font-size: 0.925rem;
    min-height: 46px;
  }
}

@media (min-width: 769px) and (max-width: 1024px) {
  .service-card {
    min-height: 410px;
  }
  
  .service-header {
    height: 135px;
  }
}

@media (min-width: 1025px) {
  .service-card {
    min-height: 440px;
  }
  
  .service-header {
    height: 150px;
  }
  
  .emergency-btn {
    padding: 16px 24px;
    font-size: 1rem;
    min-height: 52px;
  }
}

/* Custom scrollbar if needed */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px;
}
</style>