<template>
<div class="flex flex-col w-[350px] md:w-[300px] rounded-2xl   shadow-sm  ">

    <h2 class="text-xl bg-blue-800 rounded-b rounded-2xl text-white p-16 text-center">{{service.name}}</h2
    >
    <div class="p-4">
        <h1>Icon</h1>
        <h2 class="text-xl">{{service.name}}</h2>
        <p class="text-sm text-gray-500" >{{service.description}}

        </p>
        <div class="flex text-gray-500 text-sm"><span>Icon</span><h1>Min response</h1></div>
    </div>

</div>
</template>


<script setup>
defineProps({
  service: {
    type: Object,
    required: true
  }
});
</script>