<template>
    <div>
        <Head>
          <!-- <link rel="icon" type="image/png" :href="app_url+'/images/ff-favicon.png'" /> -->
        </Head>
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
