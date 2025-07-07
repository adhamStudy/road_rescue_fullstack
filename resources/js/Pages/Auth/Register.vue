<template>
  <HomeLayout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
      <div class="max-w-6xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Main Container -->
        <div class="flex flex-col lg:flex-row min-h-[600px]">
          
          <!-- Login Form Section - Left on large screens, top on mobile -->
          <div class="flex-1 p-8 lg:p-12 flex items-center justify-center order-2 lg:order-1">
            <div class="w-full max-w-md">
              
              <!-- Header -->
              <div class="text-center mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                 Signup page
                </h1>
                <p class="text-gray-600">
                  Please register a new account
                </p>
              </div>

              <!-- Login Form -->
              <form class="space-y-6">
                <!-- Name Field -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Name
                  </label>
                  <input 
                    type="name" 
                    id="name" 
                    name="name" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 outline-none"
                    placeholder="Enter your name"
                  />
                </div>
                <!-- Email Field -->
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                  </label>
                  <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 outline-none"
                    placeholder="Enter your email"
                  />
                </div>

                <!-- Password Field -->
                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                  </label>
                  <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 outline-none"
                    placeholder="Enter your password"
                  />
                </div>

                <!-- Password Confirmation -->
                <div>
                  <label for="password confirm" class="block text-sm font-medium text-gray-700 mb-2">
                    Password confirmation
                  </label>
                  <input 
                    type="password" 
                    id="password confirm" 
                    name="password_confirmation" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 outline-none"
                    placeholder="Enter your password"
                  />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <input 
                      id="remember-me" 
                      name="remember-me" 
                      type="checkbox" 
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    />
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                      Remember me
                    </label>
                  </div>
                  <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                    Forgot password?
                  </a>
                </div>

                <!-- Submit Button -->
                <button 
                  type="submit"
                  class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                >
               Signup
                </button>

                <!-- Social Login Divider -->
                <div class="relative my-6">
                  <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                  </div>
                  <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                  </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="grid grid-cols-2 gap-3">
                  <button 
                    type="button"
                    class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-lg bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                  >
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                      <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                      <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                      <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="ml-2">Google</span>
                  </button>
                  <button 
                    type="button"
                    class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-lg bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                  >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span class="ml-2">Facebook</span>
                  </button>
                </div>

                <!-- Sign Up Link -->
                <p class="text-center text-sm text-gray-600 mt-6">
                  Already have an account?
                  <a href="/login" class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors duration-200">
                    Sign in 
                  </a>
                </p>

              </form>
            </div>
          </div>

          <!-- Image Section - Right on large screens, bottom on mobile -->
          <div class="flex-1 relative order-1 lg:order-2 bg-gradient-to-br from-indigo-600 to-purple-700">
            <!-- Fallback background if image fails to load -->
            <div class="absolute inset-0 "></div>
            
            <!-- Image with error handling -->
            <img 
              src="/public/assets/images/signup_logo.jpg" 
              alt="Login illustration" 
              class="w-full h-full object-cover "
              @error="handleImageError"
              @load="handleImageLoad"
            />
            
            <!-- Overlay Content -->
            <!-- <div class="absolute inset-0 flex items-center justify-center p-8">
              <div class="text-center text-white">
                <h2 class="text-2xl lg:text-3xl font-bold mb-4 drop-shadow-lg">
                  Join Our Community
                </h2>
                <p class="text-lg opacity-90 drop-shadow-md max-w-md">
                  Discover amazing features and connect with thousands of users worldwide
                </p>
              </div>
              </div> -->
          </div>

        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import HomeLayout from '../../Layouts/HomeLayout.vue'

// Handle image loading errors
const handleImageError = (event) => {
  console.log('Image failed to load:', event.target.src)
  // Hide the image if it fails to load, fallback gradient will show
  event.target.style.display = 'none'
}

const handleImageLoad = (event) => {
  console.log('Image loaded successfully:', event.target.src)
}
</script>

<style scoped>
/* Custom styles for enhanced animations */
.transform {
  transition: transform 0.2s ease-in-out;
}

/* Responsive adjustments for very small screens */
@media (max-width: 640px) {
  .min-h-\[600px\] {
    min-height: auto;
  }
}
</style>
