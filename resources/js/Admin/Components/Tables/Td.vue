<script setup>
defineProps(['value']);
</script>

<template>
    <td class="px-6 align-middle  lg:border-solid py-3 text-sm  border-b-0 lg:border-b whitespace-nowrap text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100 block border-0 lg:table-cell">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </td>
</template>
