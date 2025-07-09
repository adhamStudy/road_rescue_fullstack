<template>


    <HomeLayout>
        <ServicesSection :services="services" />
       
    </HomeLayout>

</template>

<script setup>
import ServicesSection from '../Components/ServicesComponents/ServicesSection.vue';
    import HomeLayout from '../Layouts/HomeLayout.vue';
    import { usePage } from '@inertiajs/vue3';
    const { services } = usePage().props;
</script>