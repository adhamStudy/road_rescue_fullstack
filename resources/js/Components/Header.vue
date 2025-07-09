<template>
  <div class="h-14 bg-gradient-to-r from-white to-gray-300 p-12 flex justify-between items-center shadow-lg relative">
    <!-- Logo with hover effect -->
    <h1 class="w-fit text-3xl font-semibold italic text-gray-800 hover:text-blue-600 transition-all duration-300 hover:scale-105 hover:drop-shadow-lg cursor-pointer logo-hover">
      Road Rescue
    </h1>
    
    <!-- Desktop Navigation Menu -->
    <div class="hidden md:block">
      <ul class="flex space-x-8 mr-10 text-2xl">
        <li class="nav-item group">
          <a href="/" class="nav-link">
            Home
            <span class="nav-underline"></span>
          </a>
        </li>
        <li class="nav-item group">
          <a href="/services" class="nav-link">
            Services
            <span class="nav-underline"></span>
          </a>
        </li>
        <li class="nav-item group">
          <a href="/how-it-works" class="nav-link">
            How It Works
            <span class="nav-underline"></span>
          </a>
        </li>
        <li class="nav-item group">
          <a href="/about" class="nav-link">
            About
            <span class="nav-underline"></span>
          </a>
        </li>
        <li v-if="!user" class="nav-item group">
          <a href="/login" class="nav-link">
            Sign in 
            <span class="nav-underline"></span>
          </a>
        </li>
        <li v-if="!user" class="nav-item group">
          <a href="/register" class="nav-link">
            Register
            <span class="nav-underline"></span>
          </a>
        </li>
        <li v-else class="nav-item group relative">
          <div class="flex items-center space-x-2 mt-2">
            <h2 class="text-gray-800">
              {{user.name}}
            </h2>
            <button 
              @click="toggleLogoutDialog"
              class="p-1 rounded-full hover:bg-gray-200 transition-all duration-200 hover:scale-110"
            >
              <svg class="w-5 h-5 text-gray-600 hover:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
            </button>
          </div>
          
          <!-- Logout Dialog -->
          <div 
            v-if="isLogoutDialogOpen"
            class="absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 animate-fade-in"
          >
            <div class="p-4">
              <p class="text-sm text-gray-600 mb-3">Are you sure you want to sign out?</p>
              <div class="flex space-x-2">
                <button 
                  @click="handleSignOut"
                  class="flex-1 bg-red-500 text-white text-sm font-medium py-2 px-3 rounded hover:bg-red-600 transition-colors duration-200"
                >
                  Sign Out
                </button>
                <button 
                  @click="closeLogoutDialog"
                  class="flex-1 bg-gray-300 text-gray-700 text-sm font-medium py-2 px-3 rounded hover:bg-gray-400 transition-colors duration-200"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <!-- Mobile Hamburger Button -->
    <button 
      @click="toggleMobileMenu"
      class="md:hidden relative z-50 w-10 h-10 flex flex-col justify-center items-center space-y-1 transition-all duration-300 hover:scale-110"
      :class="{ 'open': isMobileMenuOpen }"
    >
      <span class="hamburger-line" :class="{ 'rotate-45 translate-y-2': isMobileMenuOpen }"></span>
      <span class="hamburger-line" :class="{ 'opacity-0': isMobileMenuOpen }"></span>
      <span class="hamburger-line" :class="{ '-rotate-45 -translate-y-2': isMobileMenuOpen }"></span>
    </button>

    <!-- Mobile Menu Overlay -->
    <div 
      v-if="isMobileMenuOpen"
      @click="closeMobileMenu"
      class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 md:hidden"
    ></div>

    <!-- Mobile Navigation Menu -->
    <div 
      class="fixed top-0 right-0 h-full w-80 bg-gradient-to-b from-white to-gray-100 shadow-2xl transform transition-transform duration-300 ease-in-out z-40 md:hidden"
      :class="{ 'translate-x-0': isMobileMenuOpen, 'translate-x-full': !isMobileMenuOpen }"
    >
      <!-- Mobile Menu Header -->
      <div class="p-6 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800">Menu</h2>
      </div>

      <!-- Mobile Menu Items -->
      <nav class="p-6">
        <ul class="space-y-4">
          <li class="mobile-nav-item">
            <a 
              href="/" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Home
            </a>
          </li>
          <li class="mobile-nav-item">
            <a 
              href="/services" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
              </svg>
              Services
            </a>
          </li>
          <li class="mobile-nav-item">
            <a 
              href="/how-it-works" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              How It Works
            </a>
          </li>
          <li class="mobile-nav-item">
            <a 
              href="/about" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              About
            </a>
          </li>
          <li class="mobile-nav-item">
            <a 
              href="/contact" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              Contact
            </a>
          </li>
          <li class="mobile-nav-item">
            <a v-if="!user"
              href="/login" 
              @click="closeMobileMenu"
              class="mobile-nav-link"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              Sign in
            </a>

            <div v-else class="space-y-3">
              <div class="flex items-center space-x-3 text-lg font-medium text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>{{user.name}}</span>
              </div>
              
              <!-- Mobile Logout Button -->
              <button 
                @click="handleSignOut"
                class="w-full flex items-center space-x-3 text-red-600 hover:text-red-700 hover:bg-red-50 p-3 rounded-lg transition-all duration-200 text-lg font-medium"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Sign Out</span>
              </button>
            </div>
          </li>
        </ul>

        <!-- Mobile CTA Button -->
        <div class="mt-8 pt-6 border-t border-gray-200">
          <button 
            @click="closeMobileMenu"
            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg"
          >
            Get Emergency Help
          </button>
        </div>
      </nav>
    </div>

    <!-- Logout Dialog Overlay (for desktop) -->
    <div 
      v-if="isLogoutDialogOpen"
      @click="closeLogoutDialog"
      class="fixed inset-0 z-40 hidden md:block"
    ></div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const isMobileMenuOpen = ref(false)
const isLogoutDialogOpen = ref(false)

const user = usePage().props.auth.user

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

const toggleLogoutDialog = () => {
  isLogoutDialogOpen.value = !isLogoutDialogOpen.value
}

const closeLogoutDialog = () => {
  isLogoutDialogOpen.value = false
}

const handleSignOut = () => {
  // Close any open dialogs/menus
  closeLogoutDialog()
  closeMobileMenu()
  
  // Inertia logout with DELETE method
  router.delete('/logout', {
    onSuccess: () => {
      window.location.href = '/' // Force full page reload after logout
    },
    onError: (errors) => {
      console.error('Logout failed:', errors)
    }
  })
}


// Close menu when clicking outside or pressing Escape
const handleKeydown = (event) => {
  if (event.key === 'Escape') {
    closeMobileMenu()
    closeLogoutDialog()
  }
}

// Add event listeners when component mounts
onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
})

// Clean up event listeners when component unmounts
onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
})
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>