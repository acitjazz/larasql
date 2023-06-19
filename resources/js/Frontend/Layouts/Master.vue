<template>
    <div>
        <Head></Head>
        <Header />
         <slot />
        <Footer/>
    </div>
  </template>
  <script setup>
  import Header from '@/Frontend/Layouts/Header.vue';
  import Footer from '@/Frontend/Layouts/Footer.vue';
  import { ref } from 'vue';
  </script>
