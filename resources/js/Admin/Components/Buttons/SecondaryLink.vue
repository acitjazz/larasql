<script setup>
import { Link } from '@inertiajs/inertia-vue3';
const props = defineProps(['href', 'active']);

</script>

<template>
    <Link :href="href" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot />
    </Link>
</template>
