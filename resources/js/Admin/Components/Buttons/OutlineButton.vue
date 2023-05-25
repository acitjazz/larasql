<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <Link  class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md
                font-semibold text-xs text-gray-700
                hover:bg-gray-700 active:bg-gray-700
                hover:text-white active:text-white
                focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot />
    </Link>
</template>
