<script setup>
defineProps(['value']);
</script>

<template>
    <label class="block font-medium text-sm text-gray-800 mb-2" v-if="value">
        {{ value }}
    </label>
    <label class="block font-medium text-sm text-gray-800 mb-2" v-else>
        <slot />
    </label>
</template>
