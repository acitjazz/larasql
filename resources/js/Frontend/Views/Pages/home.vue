<template>
    <Head>
      <title>{{ page.meta.title }}</title>
      <meta head-key="description" name="description" :content="page.meta.description" />
    </Head>
      <Master>
        <h1>HOME</h1>
      </Master>
  </template>

  <script setup>
  import { ref } from 'vue';
  let props  = defineProps({
      page: Object,
  });
  const isServer = ref(typeof window === 'undefined');
  </script>
