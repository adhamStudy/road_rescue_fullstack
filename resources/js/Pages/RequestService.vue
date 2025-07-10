<template>
  <HomeLayout>
    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">
      <h2 class="text-2xl font-bold mb-4 text-center">Request Road Rescue</h2>
      
     
      
      <form @submit.prevent="submitRequest">
        <!-- Service Selection -->
        <div class="mb-4">
          <label class="block mb-1 font-medium">Service</label>
          <select 
            v-model="form.service_id" 
            class="w-full border rounded px-3 py-2"
            :class="{ 'border-red-500': $page.props.errors?.service_id }"
          >
            <option value="">-- Select Service --</option>
            <option v-for="service in services" :key="service.id" :value="service.id">
              {{ service.name }}
            </option>
          </select>
        </div>

        <!-- Vehicle Type -->
        <div class="mb-4">
          <label class="block mb-1 font-medium">Vehicle Type</label>
          <input 
            v-model="form.vehicle_type" 
            type="text" 
            class="w-full border rounded px-3 py-2" 
            :class="{ 'border-red-500': $page.props.errors?.vehicle_type }"
            placeholder="e.g., Sedan, SUV" 
          />
        </div>

        <!-- Vehicle Model -->
        <div class="mb-4">
          <label class="block mb-1 font-medium">Vehicle Model</label>
          <input 
            v-model="form.vehicle_model" 
            type="text" 
            class="w-full border rounded px-3 py-2" 
            :class="{ 'border-red-500': $page.props.errors?.vehicle_model }"
            placeholder="e.g., Toyota Corolla 2020" 
          />
        </div>

        <!-- Issue Description -->
        <div class="mb-4">
          <label class="block mb-1 font-medium">Issue Description</label>
          <textarea 
            v-model="form.issue_description" 
            class="w-full border rounded px-3 py-2" 
            rows="3"
            :class="{ 'border-red-500': $page.props.errors?.issue_description }"
          ></textarea>
        </div>

        <!-- Location (auto-filled) -->
        <div class="mb-4 text-sm text-gray-600">
          <span>📍 Location: </span>
          <span v-if="form.lat && form.lng" class="text-green-600">
            Lat: {{ form.lat.toFixed(6) }}, Lng: {{ form.lng.toFixed(6) }}
          </span>
          <span v-else-if="locationError" class="text-red-600">
            {{ locationError }}
          </span>
          <span v-else class="text-yellow-600">
            Requesting location...
          </span>
        </div>

        <!-- Submit Button -->
        <button 
          type="submit" 
          :disabled="isSubmitting || !form.lat || !form.lng"
          class="w-full px-4 py-2 rounded font-medium transition-colors"
          :class="[
            isSubmitting || !form.lat || !form.lng
              ? 'bg-gray-400 text-gray-200 cursor-not-allowed'
              : 'bg-blue-600 text-white hover:bg-blue-700'
          ]"
        >
          <span v-if="isSubmitting">Submitting...</span>
          <span v-else-if="!form.lat || !form.lng">Waiting for location...</span>
          <span v-else>Submit Request</span>
        </button>
      </form>
    </div>
  </HomeLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import HomeLayout from '../Layouts/HomeLayout.vue';

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
const locationError = ref('');

// Load available services (passed from backend)
const props = defineProps({
  services: Array,
});

// Get user location on mount
onMounted(() => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.value.lat = position.coords.latitude;
        form.value.lng = position.coords.longitude;
        locationError.value = '';
      },
      (error) => {
        let errorMessage = 'Location access denied.';
        switch(error.code) {
          case error.PERMISSION_DENIED:
            errorMessage = 'Location access denied. Please allow location access.';
            break;
          case error.POSITION_UNAVAILABLE:
            errorMessage = 'Location information unavailable.';
            break;
          case error.TIMEOUT:
            errorMessage = 'Location request timed out.';
            break;
        }
        locationError.value = errorMessage;
      },
      {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 60000
      }
    );
  } else {
    locationError.value = 'Geolocation is not supported by this browser.';
  }
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
    alert('Please wait for location to be obtained.');
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