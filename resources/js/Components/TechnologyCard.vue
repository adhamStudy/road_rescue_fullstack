<script setup lang="ts">
// Define props for the component
interface Props {
  title: string;
  description: string;
  icon: string;
}

const props = defineProps<Props>();
</script>

<template>
  <div
    class="w-[250px] h-[150px] flex flex-col items-center justify-center gap-2 
           bg-gradient-to-bl from-gray-200 to-gray-100 shadow-md rounded-2xl 
           transition-all duration-500 ease-in-out transform hover:-translate-y-2 
           hover:scale-105 hover:shadow-2xl hover:rotate-[1deg] hover:border-2 hover:border-blue-400
           hover:bg-gradient-to-tr hover:from-blue-100 hover:to-white group cursor-pointer relative overflow-hidden"
  >
    <!-- Glowing Animated Border -->
    <div class="absolute -inset-[2px] opacity-0 
                group-hover:opacity-100 blur-xl rounded-2xl z-0 animate-pulse transition-all duration-700"></div>

    <!-- Content (on top of glow) -->
    <div class="relative z-10 flex flex-col items-center justify-center gap-2">
      <!-- Icon -->
      <div class="p-2 bg-blue-100 rounded-full group-hover:animate-spin-slow transition-transform duration-500">
        <img
          width="24"
          height="24"
          :src="props.icon"
          :alt="`${props.title} Icon`"
        />
      </div>

      <!-- Title -->
      <h1 class="font-bold text-gray-800 group-hover:text-blue-600 transition-all duration-300">
        {{ props.title }}
      </h1>

      <!-- Description -->
      <p class="text-[12px] text-center text-gray-500 group-hover:text-gray-700 transition-all duration-300">
        {{ props.description }}
      </p>
    </div>
  </div>
</template>