<template>
  <HomeLayout>
    <div class="max-w-4xl mx-auto p-6">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-center mb-4">Thank You For Your Request</h1>
        
        <div class="flex items-center justify-center mb-4">
          <div class="bg-blue-100 text-blue-800 font-semibold py-2 px-4 rounded-full">
            Status: {{ statusLabel }}
          </div>
        </div>
        
        <div class="text-center mb-6">
          <p class="mb-3">We've received your request for assistance with your {{ serviceRequest.vehicle_type }} ({{ serviceRequest.vehicle_model }}).</p>
          <p class="mb-3">A technician will be dispatched to your location soon. Please be patient and stay at your current location.</p>
          <p class="text-sm text-gray-500">Request ID: {{ serviceRequest.id }}</p>
        </div>
        
        <!-- Request Details -->
        <div class="mb-6 border-t border-b py-4">
          <h2 class="text-xl font-semibold mb-3">Request Details</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><span class="font-medium">Service Type:</span> {{ serviceRequest.service.name }}</p>
              <p><span class="font-medium">Vehicle:</span> {{ serviceRequest.vehicle_type }}</p>
              <p><span class="font-medium">Model:</span> {{ serviceRequest.vehicle_model }}</p>
            </div>
            <div>
              <p><span class="font-medium">Status:</span> {{ statusLabel }}</p>
              <p><span class="font-medium">Created:</span> {{ formatDate(serviceRequest.created_at) }}</p>
              <p v-if="serviceRequest.issue_description"><span class="font-medium">Issue:</span> {{ serviceRequest.issue_description }}</p>
            </div>
          </div>
        </div>
        
        <!-- Map -->
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-3">Your Location</h2>
          <div class="h-64 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden" ref="mapContainer">
            <!-- Map will be rendered here -->
            <div v-if="!mapLoaded" class="flex items-center justify-center h-full">
              <p>Your location: {{ serviceRequest.lat }}, {{ serviceRequest.lng }}</p>
            </div>
          </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-center space-x-4">
          <!-- <a :href="dashboardUrl" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded">
            Return to Dashboard
          </a> -->
          <a :href="checkStatusUrl" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Refresh Status
          </a>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';

const props = defineProps({
  serviceRequest: Object
});

const mapContainer = ref(null);
const mapLoaded = ref(false);
let map = null;
let marker = null;

// URLs for navigation - don't use route() helper directly
const dashboardUrl = '/dashboard';
const checkStatusUrl = `/service-requests/${props.serviceRequest.id}/check-status`;

// Status labels for better display
const statusLabels = {
  'pending': 'Pending',
  'accepted': 'Technician Assigned',
  'in_progress': 'Technician En Route',
  'completed': 'Completed',
  'cancelled': 'Cancelled'
};

const statusLabel = computed(() => {
  return statusLabels[props.serviceRequest.status] || props.serviceRequest.status;
});

// Format date for better readability
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleString();
};

// Function to initialize the map
const initializeMap = () => {
  if (!mapContainer.value) return;
  
  // Check if the leaflet library is available
  if (typeof L !== 'undefined') {
    // Initialize the map
    map = L.map(mapContainer.value).setView([props.serviceRequest.lat, props.serviceRequest.lng], 15);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    
    // Add a marker for the user's location
    marker = L.marker([props.serviceRequest.lat, props.serviceRequest.lng])
      .addTo(map)
      .bindPopup('Your Location')
      .openPopup();
      
    mapLoaded.value = true;
  } else {
    console.error('Leaflet library is not loaded.');
    mapLoaded.value = false;
  }
};

onMounted(() => {
  // Load Leaflet library dynamically if not already loaded
  if (typeof L === 'undefined') {
    const linkElement = document.createElement('link');
    linkElement.rel = 'stylesheet';
    linkElement.href = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css';
    document.head.appendChild(linkElement);
    
    const scriptElement = document.createElement('script');
    scriptElement.src = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js';
    scriptElement.onload = () => {
      initializeMap();
      mapLoaded.value = true;
    };
    document.head.appendChild(scriptElement);
  } else {
    // If already loaded, initialize immediately
    initializeMap();
  }
});
</script>