<template>
    <div>
        <div v-if="showPopup" class="popup-wrapper fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
            <div class="w-full h-full flex items-center justify-center">
                <div class="bg-white max-w-[400px] mx-auto p-10 relative">
                    <div class="popup-header">
                        <a class="absolute top-3 right-5 cursor-pointer" @click="showPopup = !showPopup"><i class="fas fa-xmark"></i></a>
                    </div>
                    <div class="text-center mb-5">
                        <h3 class="font-bold text-xl">Thank You</h3>
                        <p>Thank you for Redeem voucher.</p>
                    </div>
                    <PrimaryButton :href="route('point.index',{'redeem_history' : 1})" class="block w-full text-center py-3 px-3 justify-center">
                        History Redeem
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref } from 'vue'
const showPopup = ref(false);
const close = () => {
    showPopup.value = false;
}
const firePopup = () => {
    showPopup.value = true;
}
defineExpose({ firePopup });


</script>
