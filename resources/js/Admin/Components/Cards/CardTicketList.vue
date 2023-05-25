<template>
  <div
    class=" flex flex-col min-w-0 break-words bg-white w-full mb-6  shadow-lg rounded"
  >
    <div class="bg-yellow"></div>
    <div class="relative w-full max-w-full flex items-center pt-5 pl-5">
        <span class="w-10 h-10 bg-gray-100 border border-gray-200 mr-3 flex items-center justify-center rounded"><i class="fa fa-ticket"></i></span>
        <h2 class="text-blueGray-400 text-md font-semibold">
        Ongoing Ticket
        </h2>
    </div>
    <div class="flex items-center">
        <div class="flex gap-2 px-6 py-4 items-center flex-wrap">
            <OutlineButton :href="route('dashboard')" preserve-state  :data="{ page:1, status:'OPEN' }" :class="{'bg-active':status == 'OPEN'}">Open</OutlineButton>
            <OutlineButton :href="route('dashboard')" preserve-state  :data="{ page:1, status:'PENDING' }" :class="{'bg-active':status == 'PENDING'}">Pending</OutlineButton>
        </div>
    </div>
    <div class="relative h-[350px] flex items-center justify-center" v-if="loader">
        <Loader></Loader>
    </div>
    <div  class="relative flex flex-col min-w-0 break-words w-full mb-6 rounded bg-white" v-else>
        <div class="block w-full overflow-x-auto">
        <table class="items-center w-full bg-transparent border-collapse">
            <thead>
            <tr class="hidden lg:table-row">
                <Th>
                    <div class="flex items-center">Ticket Number</div>
                </Th>
                <Th>
                    <div class="flex items-center">Service</div>
                </Th>
                <Th>
                    <div class="flex items-center">Customer Ticket</div>
                </Th>
                <Th>
                    <div class="flex items-center">Status</div>
                </Th>
                <Th></Th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="ticket in tickets.data" :key="ticket.uuid" class="hover:bg-gray-100 cursor-pointer relative py-3 block lg:py-0 lg:table-row border-t lg:border-0" @click="showPopup(ticket,category)">
                <Td>
                    <strong class="block lg:hidden">Ticket Number</strong>
                    <span>{{ ticket.ticketNumber }}</span>
                </Td>
                <Td>
                    <strong class="block lg:hidden">Service</strong>
                    <span>{{ ticket.serviceNumber }}</span>
                </Td>
                <Td>
                    <strong class="block lg:hidden">Subject</strong>
                    <span>{{ ticket.customerTicket }}</span>
                </Td>
                <Td>
                    <span><Badge :class="ticket.status.class">{{ ticket.status.label }}</Badge></span>
                </Td>
                <Td class="absolute top-3 right-2 lg:relative lg:top-0 lg:right-0">
                        <i class="fas fa-chevron-right"></i>
                </Td>
            </tr>
            </tbody>
        </table>

        </div>
    </div>
    <!-- <PopupDetailTicket ref="popupDetailTicket"></PopupDetailTicket> -->
  </div>
</template>
<script setup>
import axios from 'axios';
import { ref,onMounted } from 'vue';
import { defineAsyncComponent } from 'vue';
import { useBuildQuery } from '@/Composables/useBuildQuery';

let props  = defineProps({
    category:[Object,String],
    tickets:Object,
    status:String,
});

// const PopupDetailTicket = defineAsyncComponent(
//     () => import('@/Admin/Components/Popups/PopupDetailTicket.vue')
// )

const params = ref({
    status:'',
});
const loader = ref(false);
const popupDetailTicket = ref(null);
const showPopup = (ticket,category) => {
    popupDetailTicket.value.firePopup(ticket, category)

}
</script>
