<script setup>
import {watch, onMounted, ref } from 'vue';

const props = defineProps(['modelValue','source']);

const emit = defineEmits(['update:modelValue']);

const input = ref(null);
let value = ref(input.value);
watch(() => props.source, (after, before) => {
    if(after){
        value = after.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        emit('update:modelValue', value)
    }
});
function changeInput(data)  {
    if(data){
        value = data.target.value.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        emit('update:modelValue', value)
    }
};
onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

</script>

<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="modelValue" @input="changeInput"  ref="input">
</template>
