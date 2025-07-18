<template>
  <HomeLayout>
    <div class="max-w-4xl mx-auto p-6">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-center mb-4">Thank You For Your Request</h1>
        
        <div class="flex items-center justify-center mb-4">
          <div 
            :class="statusBadgeClass"
            class="font-semibold py-2 px-4 rounded-full transition-colors duration-300">
            Status: {{ statusLabel }}
            <span v-if="isUpdating" class="ml-2 text-xs animate-spin">🔄</span>
          </div>
        </div>
        
        <!-- Auto-refresh indicator -->
        <div class="text-center mb-4">
          <p class="text-sm text-gray-500">
            Status updates automatically every {{ refreshInterval / 1000 }} seconds
            <button 
              @click="toggleAutoRefresh"
              :class="autoRefreshEnabled ? 'text-green-600' : 'text-red-600'"
              class="ml-2 underline hover:no-underline">
              ({{ autoRefreshEnabled ? 'ON' : 'OFF' }})
            </button>
          </p>
          <p class="text-xs text-gray-400">Last updated: {{ lastUpdated }}</p>
        </div>
        
        <div class="text-center mb-6">
          <p class="mb-3">We've received your request for assistance with your {{ serviceRequest.vehicle_type }} ({{ serviceRequest.vehicle_model }}).</p>
          <p class="mb-3" v-if="currentStatus === 'pending'">A technician will be dispatched to your location soon. Please be patient and stay at your current location.</p>
          <p class="mb-3" v-else-if="currentStatus === 'assigned'">A technician has been assigned and is on their way to your location!</p>
          <p class="mb-3" v-else-if="currentStatus === 'completed'">Your service request has been completed. Thank you for using our service!</p>
          <p class="text-sm text-gray-500">Request ID: #{{ serviceRequest.id }}</p>
        </div>
        
        <!-- Request Details -->
        <div class="mb-6 border-t border-b py-4">
          <h2 class="text-xl font-semibold mb-3">Request Details</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><span class="font-medium">Service Type:</span> {{ serviceRequest.service.name }}</p>
              <p><span class="font-medium">Vehicle:</span> {{ serviceRequest.vehicle_type }}</p>
              <p><span class="font-medium">Model:</span> {{ serviceRequest.vehicle_model }}</p>
              <p><span class="font-medium">Service Price:</span> SAR {{ formatPrice(serviceRequest.service.price) }}</p>
            </div>
            <div>
              <p><span class="font-medium">Status:</span> {{ statusLabel }}</p>
              <p><span class="font-medium">Created:</span> {{ formatDate(serviceRequest.created_at) }}</p>
              <p v-if="serviceRequest.issue_description"><span class="font-medium">Issue:</span> {{ serviceRequest.issue_description }}</p>
              <p><span class="font-medium">Location:</span> {{ serviceRequest.lat }}, {{ serviceRequest.lng }}</p>
            </div>
          </div>
        </div>

        <!-- Technician Info (when assigned) -->
        <div v-if="technicianInfo" class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 transition-all duration-500">
          <h3 class="text-lg font-semibold text-green-800 mb-2">
            <span class="mr-2">👨‍🔧</span>
            Technician Assigned!
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><span class="font-medium">Name:</span> {{ technicianInfo.name }}</p>
              <p><span class="font-medium">Phone:</span> 
                <a :href="`tel:${technicianInfo.phone}`" class="text-blue-600 hover:underline">
                  {{ technicianInfo.phone }}
                </a>
              </p>
            </div>
            <div>
              <p><span class="font-medium">Rating:</span> {{ technicianInfo.rating }}/5 ⭐</p>
              <p><span class="font-medium">Availability:</span> 
                <span :class="technicianInfo.is_available ? 'text-green-600' : 'text-red-600'">
                  {{ technicianInfo.is_available ? 'Available' : 'Busy' }}
                </span>
              </p>
            </div>
          </div>
        </div>

        <!-- Bill Information (when completed) -->
        <div v-if="billInfo" class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
          <h3 class="text-lg font-semibold text-blue-800 mb-2">
            <span class="mr-2">💰</span>
            Billing Information
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><span class="font-medium">Base Price:</span> SAR {{ formatPrice(billInfo.base_price) }}</p>
              <p v-if="billInfo.night_tax > 0"><span class="font-medium">Night Service Tax:</span> SAR {{ formatPrice(billInfo.night_tax) }}</p>
              <p><span class="font-medium">Total Amount:</span> 
                <span class="text-lg font-bold text-blue-600">SAR {{ formatPrice(billInfo.total_amount) }}</span>
              </p>
            </div>
            <div>
              <p><span class="font-medium">Payment Status:</span> 
                <span 
                  :class="billStatusClass"
                  class="px-2 py-1 rounded text-sm font-medium">
                  {{ billInfo.status }}
                </span>
              </p>
              <p v-if="billInfo.is_night_service" class="text-sm text-orange-600">
                <span class="mr-1">🌙</span>
                Night service surcharge applied
              </p>
            </div>
          </div>
        </div>
        
        <!-- Map -->
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-3">Your Location</h2>
          <div class="h-64 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden" ref="mapContainer">
            <div v-if="!mapLoaded" class="flex items-center justify-center h-full">
              <div class="text-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-2"></div>
                <p>Loading map...</p>
                <p class="text-sm text-gray-500">{{ serviceRequest.lat }}, {{ serviceRequest.lng }}</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Actions -->
        <div class="flex flex-wrap justify-center gap-4">
          <button 
            @click="checkStatus" 
            :disabled="isUpdating"
            class="bg-blue-500 hover:bg-blue-600 disabled:bg-blue-300 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ isUpdating ? 'Checking...' : 'Check Status Now' }}
          </button>
          
          <button 
            @click="toggleAutoRefresh"
            :class="autoRefreshEnabled ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-500 hover:bg-gray-600'"
            class="text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            {{ autoRefreshEnabled ? 'Auto-Refresh ON' : 'Auto-Refresh OFF' }}
          </button>

          <a 
            href="/"
            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded transition-colors duration-200">
            Back to Home
          </a>
        </div>

        <!-- Connection Status -->
        <div class="mt-4 text-center">
          <p :class="isOnline ? 'text-green-600' : 'text-red-600'" class="text-sm">
            <span class="mr-1">{{ isOnline ? '🟢' : '🔴' }}</span>
            {{ isOnline ? 'Connected' : 'Offline' }}
            {{ !isOnline ? '- Status updates paused' : '' }}
          </p>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';

const props = defineProps({
  serviceRequest: Object
});

// Reactive data
const mapContainer = ref(null);
const mapLoaded = ref(false);
const currentStatus = ref(props.serviceRequest.status);
const technicianInfo = ref(props.serviceRequest.technician || null);
const billInfo = ref(props.serviceRequest.bill || null);
const isUpdating = ref(false);
const lastUpdated = ref(new Date().toLocaleTimeString());
const autoRefreshEnabled = ref(true);
const refreshInterval = ref(30000); // 30 seconds
const isOnline = ref(navigator.onLine);

let map = null;
let marker = null;
let refreshIntervalId = null;

// Status labels for better display
const statusLabels = {
  'pending': 'Pending Assignment',
  'assigned': 'Technician Assigned',
  'completed': 'Service Completed',
  'cancelled': 'Cancelled'
};

// Computed properties
const statusLabel = computed(() => {
  return statusLabels[currentStatus.value] || currentStatus.value;
});

const statusBadgeClass = computed(() => {
  const baseClass = 'transition-colors duration-300 ';
  switch (currentStatus.value) {
    case 'pending':
      return baseClass + 'bg-yellow-100 text-yellow-800';
    case 'assigned':
      return baseClass + 'bg-blue-100 text-blue-800';
    case 'completed':
      return baseClass + 'bg-green-100 text-green-800';
    case 'cancelled':
      return baseClass + 'bg-red-100 text-red-800';
    default:
      return baseClass + 'bg-gray-100 text-gray-800';
  }
});

const billStatusClass = computed(() => {
  if (!billInfo.value) return '';
  
  switch (billInfo.value.status) {
    case 'paid':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    case 'cancelled':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
});

// Helper functions
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleString();
};

const formatPrice = (price) => {
  return parseFloat(price).toFixed(2);
};

// Check status from server
const checkStatus = async () => {
  if (!isOnline.value) {
    showNotification('You are offline. Cannot check status.', 'error');
    return;
  }

  isUpdating.value = true;
  try {
    const response = await fetch(`/api/service-requests/${props.serviceRequest.id}/status`);
    
    if (!response.ok) {
      throw new Error('Failed to fetch status');
    }
    
    const data = await response.json();
    
    // Check if status changed
    const statusChanged = data.status !== currentStatus.value;
    
    // Update reactive variables
    currentStatus.value = data.status;
    
    // Update technician info if available
    if (data.technician) {
      technicianInfo.value = data.technician;
    }

    // Fetch detailed info if completed to get bill info
    if (data.status === 'completed' && !billInfo.value) {
      await fetchDetailedStatus();
    }
    
    lastUpdated.value = new Date().toLocaleTimeString();
    
    // Show notification if status changed
    if (statusChanged) {
      showStatusNotification(data.status);
    }
    
  } catch (error) {
    console.error('Error checking status:', error);
    showNotification('Error checking status. Please try again.', 'error');
  } finally {
    isUpdating.value = false;
  }
};

// Fetch detailed status (including bill info)
const fetchDetailedStatus = async () => {
  try {
    const response = await fetch(`/api/service-requests/${props.serviceRequest.id}/detailed-status`);
    const data = await response.json();
    
    if (data.bill) {
      billInfo.value = data.bill;
    }
  } catch (error) {
    console.error('Error fetching detailed status:', error);
  }
};

// Show status change notification
const showStatusNotification = (newStatus) => {
  const statusText = statusLabels[newStatus] || newStatus;
  
  // Browser notification
  if ('Notification' in window && Notification.permission === 'granted') {
    new Notification('Service Request Update', {
      body: `Status changed to: ${statusText}`,
      icon: '/favicon.ico'
    });
  }
  
  // Visual notification
  showNotification(`Status updated: ${statusText}`, 'success');
};

// Show visual notification
const showNotification = (message, type = 'info') => {
  const colors = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    info: 'bg-blue-500'
  };
  
  const notification = document.createElement('div');
  notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-4 py-2 rounded shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
  notification.textContent = message;
  document.body.appendChild(notification);
  
  // Slide in
  setTimeout(() => {
    notification.classList.remove('translate-x-full');
  }, 100);
  
  // Slide out and remove
  setTimeout(() => {
    notification.classList.add('translate-x-full');
    setTimeout(() => {
      if (document.body.contains(notification)) {
        document.body.removeChild(notification);
      }
    }, 300);
  }, 3000);
};

// Toggle auto-refresh
const toggleAutoRefresh = () => {
  autoRefreshEnabled.value = !autoRefreshEnabled.value;
  
  if (autoRefreshEnabled.value) {
    startAutoRefresh();
    showNotification('Auto-refresh enabled', 'info');
  } else {
    stopAutoRefresh();
    showNotification('Auto-refresh disabled', 'info');
  }
};

// Start auto-refresh
const startAutoRefresh = () => {
  if (refreshIntervalId) clearInterval(refreshIntervalId);
  
  refreshIntervalId = setInterval(() => {
    if (autoRefreshEnabled.value && !isUpdating.value && isOnline.value) {
      checkStatus();
    }
  }, refreshInterval.value);
};

// Stop auto-refresh
const stopAutoRefresh = () => {
  if (refreshIntervalId) {
    clearInterval(refreshIntervalId);
    refreshIntervalId = null;
  }
};

// Handle online/offline status
const handleOnlineStatus = () => {
  isOnline.value = navigator.onLine;
  
  if (isOnline.value) {
    showNotification('Connection restored', 'success');
    if (autoRefreshEnabled.value) {
      startAutoRefresh();
    }
  } else {
    showNotification('Connection lost', 'error');
    stopAutoRefresh();
  }
};

// Request notification permission
const requestNotificationPermission = () => {
  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }
};

// Initialize map
const initializeMap = () => {
  if (!mapContainer.value) return;
  
  if (typeof L !== 'undefined') {
    map = L.map(mapContainer.value).setView([props.serviceRequest.lat, props.serviceRequest.lng], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    // Custom marker
    const customIcon = L.divIcon({
      html: '<div style="background-color: #dc2626; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
      iconSize: [26, 26],
      iconAnchor: [13, 13]
    });
    
    marker = L.marker([props.serviceRequest.lat, props.serviceRequest.lng], { icon: customIcon })
      .addTo(map)
      .bindPopup(`
        <div>
          <strong>Your Location</strong><br>
          Service: ${props.serviceRequest.service.name}<br>
          Vehicle: ${props.serviceRequest.vehicle_type}
        </div>
      `)
      .openPopup();
      
    mapLoaded.value = true;
  }
};

// Load Leaflet
const loadLeaflet = () => {
  if (typeof L === 'undefined') {
    const linkElement = document.createElement('link');
    linkElement.rel = 'stylesheet';
    linkElement.href = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css';
    document.head.appendChild(linkElement);
    
    const scriptElement = document.createElement('script');
    scriptElement.src = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js';
    scriptElement.onload = initializeMap;
    document.head.appendChild(scriptElement);
  } else {
    initializeMap();
  }
};

// Component lifecycle
onMounted(() => {
  // Request notification permission
  requestNotificationPermission();
  
  // Set up online/offline listeners
  window.addEventListener('online', handleOnlineStatus);
  window.addEventListener('offline', handleOnlineStatus);
  
  // Start auto-refresh
  if (autoRefreshEnabled.value) {
    startAutoRefresh();
  }
  
  // Load map
  loadLeaflet();
  
  // Initial status check
  setTimeout(() => {
    checkStatus();
  }, 1000);
});

onUnmounted(() => {
  // Clean up
  stopAutoRefresh();
  window.removeEventListener('online', handleOnlineStatus);
  window.removeEventListener('offline', handleOnlineStatus);
});
</script>