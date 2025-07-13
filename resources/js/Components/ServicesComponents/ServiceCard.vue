<template>
  <div class="service-card" @click="handleCardClick">
    <div class="card-content">
      <!-- Header -->
      <div class="service-header">
        <h2 class="service-title">{{ service.name }}</h2>
      </div>

      <!-- Body -->
      <div class="service-body">
        <p class="service-description">{{ service.description }}</p>
        
        <!-- Features -->
        <div class="features-list">
          <span 
            v-for="feature in getServiceFeatures(service.name)" 
            :key="feature"
            class="feature-tag"
          >
            {{ feature }}
          </span>
        </div>

        <!-- Response time -->
        <div class="response-time">
          <span class="response-label">Response Time:</span>
          <span class="response-value">{{ getResponseTime(service.name) }}</span>
        </div>

        <!-- CTA Button -->
        <button class="request-btn">
          Request {{ service.name }}
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
  // Simple click feedback
  const card = event.currentTarget;
  card.style.transform = 'scale(0.98)';
  setTimeout(() => {
    card.style.transform = '';
  }, 100);
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
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 16px;
  cursor: pointer;
  transition: all 0.2s ease;
  height: 100%;
  min-height: 320px;
  padding: 24px;
}

.service-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  background: rgba(255, 255, 255, 0.8);
}

.card-content {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.service-header {
  text-align: center;
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

.service-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #374151;
  margin: 0;
}

.service-body {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.service-description {
  color: #6b7280;
  font-size: 0.875rem;
  line-height: 1.5;
  margin: 0;
}

.features-list {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.feature-tag {
  background: linear-gradient(135deg, #e0f2fe 0%, #f8fafc 100%);
  color: #0369a1;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 500;
  border: 1px solid #e0f2fe;
}

.response-time {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px;
  background: #f8fafc;
  border-radius: 8px;
  border-left: 3px solid #87ceeb;
}

.response-label {
  color: #6b7280;
  font-size: 0.875rem;
  font-weight: 500;
}

.response-value {
  color: #374151;
  font-size: 0.875rem;
  font-weight: 600;
}

.request-btn {
  background: linear-gradient(135deg, #87ceeb 0%, #60a5fa 100%);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: auto;
}

.request-btn:hover {
  background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
  transform: translateY(-1px);
}

.request-btn:active {
  transform: translateY(0);
}

/* Mobile responsive */
@media (max-width: 640px) {
  .service-card {
    min-height: 300px;
    padding: 20px;
  }
  
  .service-title {
    font-size: 1.125rem;
  }
  
  .service-body {
    gap: 14px;
  }
}

@media (min-width: 768px) {
  .service-card {
    min-height: 340px;
    padding: 28px;
  }
}
</style>