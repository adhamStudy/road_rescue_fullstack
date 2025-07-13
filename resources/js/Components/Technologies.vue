

<template>
    <div class="flex flex-col items-center mb-10">
       <div class="flex items-center mr-30">
        
            <div class="h-[40px] w-[150px] bg-linear-to-r from-gray-300 to-gray-100" ></div>
         <h2 class="text-2xl my-5">  Our Technologies</h2>

       </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <TechnologyCard 
                v-for="tech in technologies" 
                :key="tech.id"
                :title="tech.title"
                :description="tech.description"
                :icon="tech.icon"
            />
        </div>
    </div>
</template>




<script setup >
import TechnologyCard from './TechnologyCard.vue';

// Technology data array based on the image
const technologies = [
  {
    id: 1,
    title: 'GPS Tracking',
    description: 'Real-time vehicle tracking for accurate ETAs and route optimization',
    icon: 'https://img.icons8.com/?size=100&id=jgXEzIAycuVm&format=png&color=000000'
  },
  {
    id: 2,
    title: 'AI Diagnostics',
    description: 'Machine learning analyzes symptoms to predict needed repairs',
 icon: 'https://img.icons8.com/?size=100&id=jgXEzIAycuVm&format=png&color=000000'  },
  {
    id: 3,
    title: 'Mobile Platform',
    description: 'User-friendly app for seamless service requests and communication',
 icon: 'https://img.icons8.com/?size=100&id=jgXEzIAycuVm&format=png&color=000000'  },
  {
    id: 4,
    title: 'IoT Integration',
    description: 'Vehicle monitoring for predictive maintenance alerts',
 icon: 'https://img.icons8.com/?size=100&id=jgXEzIAycuVm&format=png&color=000000'  }
];
</script>