<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <a  class="inline-flex items-center px-4 py-2 bg-primary border
                        border-transparent rounded-md font-semibold text-xs text-white
                        hover:bg-gray-700 active:bg-gray-900
                        focus:outline-none focus:border-gray-900 focus:shadow-outline-gray
                        transition ease-in-out duration-150">
        <slot />
    </a>
</template>
