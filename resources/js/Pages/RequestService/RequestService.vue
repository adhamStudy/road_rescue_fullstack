<template>
  <HomeLayout>
    <!-- Hero Section -->
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
      <!-- Header Section -->
      

      <!-- Main Form Container -->
      <div class="relative max-w-2xl mt-10 mx-auto px-6 pb-16">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
          <!-- Form Header -->
          <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Service Request Form</h2>
            <p class="text-gray-600">Fill in the details below and we'll dispatch help immediately</p>
          </div>

          <!-- Form Content -->
          <form @submit.prevent="submitRequest" class="p-8 space-y-8">
            
            <!-- Service Selection -->
            <div class="space-y-2">
              <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs mr-3">1</span>
                Select Service Type
              </label>
              <div class="relative">
                <select 
                  v-model="form.service_id" 
                  class="w-full appearance-none bg-white border-2 border-gray-200 rounded-xl px-4 py-4 text-gray-700 leading-tight focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200"
                  :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-100': $page.props.errors?.service_id }"
                >
                  <option value="">Choose the service you need...</option>
                  <option v-for="service in services" :key="service.id" :value="service.id">
                    {{ service.name }}
                  </option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Vehicle Information -->
            <div class="grid md:grid-cols-2 gap-6">
              <!-- Vehicle Type -->
              <div class="space-y-2">
                <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                  <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs mr-3">2</span>
                  Vehicle Type
                </label>
                <div class="relative">
                  <input 
                    v-model="form.vehicle_type" 
                    type="text" 
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" 
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-100': $page.props.errors?.vehicle_type }"
                    placeholder="e.g., Sedan, SUV, Truck" 
                  />
                  <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a5 5 0 1110 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Vehicle Model -->
              <div class="space-y-2">
                <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                  <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs mr-3">3</span>
                  Vehicle Model
                </label>
                <div class="relative">
                  <input 
                    v-model="form.vehicle_model" 
                    type="text" 
                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" 
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-100': $page.props.errors?.vehicle_model }"
                    placeholder="e.g., Toyota Corolla 2020" 
                  />
                  <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                  </div>
                </div>
              </div>
            </div>

            <!-- Issue Description -->
            <div class="space-y-2">
              <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs mr-3">4</span>
                Describe the Issue
              </label>
              <div class="relative">
                <textarea 
                  v-model="form.issue_description" 
                  class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 resize-none" 
                  rows="4"
                  :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-100': $page.props.errors?.issue_description }"
                  placeholder="Please describe what happened and any symptoms you've noticed..."
                ></textarea>
                <div class="absolute top-4 right-4 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Enhanced Location Section -->
            <div class="space-y-2">
              <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs mr-3">5</span>
                Your Location
              </label>
              
              <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-100">
                <div class="flex items-center justify-between mb-4">
                  <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                      </svg>
                    </div>
                    <span class="font-medium text-gray-700">Location Status</span>
                  </div>
                  <button 
                    type="button" 
                    @click="retryLocation" 
                    :disabled="isGettingLocation"
                    class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:scale-105"
                  >
                    <span v-if="isGettingLocation" class="flex items-center">
                      <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      Getting...
                    </span>
                    <span v-else>📍 Retry</span>
                  </button>
                </div>
                
                <!-- Location Status Display -->
                <div class="space-y-3">
                  <div v-if="locationStatus === 'success'" class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-green-800 font-medium">Location obtained successfully!</p>
                        <p class="text-green-600 text-sm mt-1">
                          Coordinates: {{ form.lat.toFixed(6) }}, {{ form.lng.toFixed(6) }}
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <div v-else-if="locationStatus === 'loading'" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                        <svg class="animate-pulse w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                        </svg>
                      </div>
                      <div>
                        <p class="text-yellow-800 font-medium">Getting your location...</p>
                        <p class="text-yellow-600 text-sm mt-1">Please ensure location services are enabled</p>
                      </div>
                    </div>
                  </div>
                  
                  <div v-else-if="locationStatus === 'error'" class="space-y-4">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                      <div class="flex items-start">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3 mt-0.5">
                          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                        </div>
                        <div>
                          <p class="text-red-800 font-medium">{{ locationError }}</p>
                          <div class="text-red-600 text-sm mt-2">
                            <p class="font-medium mb-1">Try these solutions:</p>
                            <ul class="list-disc list-inside space-y-1">
                              <li>Enable location services in your browser</li>
                              <li>Allow location access for this website</li>
                              <li>Check device location settings</li>
                              <li>Refresh the page and try again</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Manual Location Input -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                      <h4 class="text-blue-800 font-medium mb-3">Enter coordinates manually:</h4>
                      <div class="grid grid-cols-2 gap-3">
                        <input 
                          v-model="form.lat" 
                          type="number" 
                          step="any"
                          placeholder="Latitude" 
                          class="border-2 border-blue-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                        />
                        <input 
                          v-model="form.lng" 
                          type="number" 
                          step="any"
                          placeholder="Longitude" 
                          class="border-2 border-blue-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
              <button 
                type="submit" 
                :disabled="isSubmitting || (!form.lat || !form.lng)"
                class="w-full relative overflow-hidden group"
              >
                <div 
                  class="w-full px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 transform"
                  :class="[
                    isSubmitting || (!form.lat || !form.lng)
                      ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                      : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 hover:scale-105 hover:shadow-lg group-hover:shadow-xl'
                  ]"
                >
                  <!-- Loading Animation -->
                  <span v-if="isSubmitting" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting Request...
                  </span>
                  
                  <!-- Waiting for Location -->
                  <span v-else-if="!form.lat || !form.lng" class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Waiting for Location...
                  </span>
                  
                  <!-- Ready to Submit -->
                  <span v-else class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Send Emergency Request
                  </span>
                </div>
                
                <!-- Hover Effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 rounded-xl"></div>
              </button>
            </div>

            <!-- Trust Indicators -->
            <div class="border-t border-gray-100 pt-6 mt-8">
              <div class="grid grid-cols-3 gap-4 text-center">
                <div class="flex flex-col items-center">
                  <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <p class="text-sm font-medium text-gray-700">24/7 Service</p>
                  <p class="text-xs text-gray-500">Always available</p>
                </div>
                
                <div class="flex flex-col items-center">
                  <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                  <p class="text-sm font-medium text-gray-700">Fast Response</p>
                  <p class="text-xs text-gray-500">15-30 minutes</p>
                </div>
                
                <div class="flex flex-col items-center">
                  <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                  </div>
                  <p class="text-sm font-medium text-gray-700">Certified Pros</p>
                  <p class="text-xs text-gray-500">Licensed & insured</p>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import HomeLayout from '../../Layouts/HomeLayout.vue';

// Form data
const form = ref({
  service_id: '',
  vehicle_type: '',
  vehicle_model: '',
  issue_description: '',
  lat: null,
  lng: null,
});

// Loading and error states
const isSubmitting = ref(false);
const isGettingLocation = ref(false);
const locationError = ref('');
const locationStatus = ref('loading'); // 'loading', 'success', 'error'

// Load available services (passed from backend)
const props = defineProps({
  services: Array,
});

// Enhanced location getting function
async function getLocation() {
  return new Promise((resolve, reject) => {
    if (!navigator.geolocation) {
      reject(new Error('Geolocation is not supported by this browser.'));
      return;
    }

    // First try with high accuracy but shorter timeout
    navigator.geolocation.getCurrentPosition(
      (position) => {
        resolve({
          lat: position.coords.latitude,
          lng: position.coords.longitude
        });
      },
      (error) => {
        // If high accuracy fails, try with lower accuracy and longer timeout
        navigator.geolocation.getCurrentPosition(
          (position) => {
            resolve({
              lat: position.coords.latitude,
              lng: position.coords.longitude
            });
          },
          (fallbackError) => {
            let errorMessage = 'Location access failed.';
            switch(fallbackError.code) {
              case fallbackError.PERMISSION_DENIED:
                errorMessage = 'Location access denied. Please allow location access in your browser settings.';
                break;
              case fallbackError.POSITION_UNAVAILABLE:
                errorMessage = 'Location information unavailable. Please check your device\'s location settings.';
                break;
              case fallbackError.TIMEOUT:
                errorMessage = 'Location request timed out. Please try again or enter coordinates manually.';
                break;
            }
            reject(new Error(errorMessage));
          },
          {
            enableHighAccuracy: false, // Lower accuracy for fallback
            timeout: 15000, // Longer timeout
            maximumAge: 300000 // 5 minutes
          }
        );
      },
      {
        enableHighAccuracy: true,
        timeout: 5000, // Shorter timeout for first attempt
        maximumAge: 60000 // 1 minute
      }
    );
  });
}

// Retry location function
async function retryLocation() {
  if (isGettingLocation.value) return;
  
  isGettingLocation.value = true;
  locationStatus.value = 'loading';
  locationError.value = '';
  
  try {
    const location = await getLocation();
    form.value.lat = location.lat;
    form.value.lng = location.lng;
    locationStatus.value = 'success';
    locationError.value = '';
  } catch (error) {
    locationStatus.value = 'error';
    locationError.value = error.message;
    console.error('Location error:', error);
  } finally {
    isGettingLocation.value = false;
  }
}

// Get user location on mount
onMounted(() => {
  retryLocation();
});

// Submit form to backend
function submitRequest() {
  if (isSubmitting.value) return;
  
  // Basic client-side validation
  if (!form.value.service_id) {
    alert('Please select a service.');
    return;
  }
  
  if (!form.value.vehicle_type) {
    alert('Please enter vehicle type.');
    return;
  }
  
  if (!form.value.vehicle_model) {
    alert('Please enter vehicle model.');
    return;
  }
  
  if (!form.value.lat || !form.value.lng) {
    alert('Please wait for location to be obtained or enter coordinates manually.');
    return;
  }
  
  isSubmitting.value = true;
  
  router.post('/request-service', form.value, {
    onSuccess: () => {
      // Reset form on success
      form.value = {
        service_id: '',
        vehicle_type: '',
        vehicle_model: '',
        issue_description: '',
        lat: form.value.lat, // Keep location
        lng: form.value.lng,
      };
      isSubmitting.value = false;
    },
    onError: (errors) => {
      console.error('Submission errors:', errors);
      isSubmitting.value = false;
    },
    onFinish: () => {
      isSubmitting.value = false;
    }
  });
}
</script>