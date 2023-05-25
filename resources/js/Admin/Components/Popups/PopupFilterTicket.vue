<template>
    <div @click="close" v-if="showPopup" class="popup-wrapper fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
    </div>
    <div v-if="loader"  class="popup-wrapper flex justify-center items-center fixed left-0 top-0 w-full h-full bg-[rgba(0,0,0,0.7)] z-[1000]">
                <Loader></Loader>
    </div>
    <div v-if="showPopup" class="overflow-x flex flex-col w-[40vw] max-w-[500px] z-[1000] mr-auto w-full absolute bg-white top-0 right-0 h-full">
        <div class="flex w-full p-5 items-center relative bg-gray-100">
            <i @click="close" class="fa fa-chevron-left w-5  text-center cursor-pointer relative z-10"></i>
            <h2 class="text-center font-semibold absolute w-full left-0 top-0 h-full flex items-center justify-center">Filter</h2>
        </div>
        <div class="flex w-full flex-col px-5 pt-10 pb-10 shadow-md border-b bg-white">
            <h2 class="font-semibold leading-3 uppercase text-gray-500">Search ticket</h2>
            <div class="block mt-6">
                <TextInput placeholder="Service Number" type="text" class="mt-1 block w-full !border-gray-300"  v-model="params.service"  autofocus />
            </div>
            <div class="block mt-6">
                <TextInput placeholder="Ticket Number" type="text" class="mt-1 block w-full !border-gray-300"  v-model="params.number"  autofocus />
            </div>
            <div class="block mt-6">
                <TextInput placeholder="Customer Ticket" type="text" class="mt-1 block w-full !border-gray-300"  v-model="params.customerTicket"  autofocus />
            </div>
        </div>
        <div class="flex w-full flex-col px-5 pt-10 pb-10 shadow-md border-b bg-white">
            <h2 class="font-semibold leading-3 uppercase text-gray-500">Date</h2>
            <div class="block mt-6">
                    <Datepicker v-model="opendate" @update:model-value="handleDateOpen" date-picker  format="yyyy-MM-dd" range placeholder="Opened date" />
            </div>
            <div class="block mt-6">
                    <Datepicker v-model="closedate" @update:model-value="handleDateClose" date-picker   format="yyyy-MM-dd" range placeholder="Closed date" />
            </div>
            <button class="text-gray-500 font-semibold my-10 text-sm hover:text-primary" @click="reset">Reset Filter</button>
            <AOutlineButton class="w-full mt-6 justify-center py-3 bg-primary text-white" @click="changeParams">Submit</AOutlineButton>
        </div>
    </div>
</template>

<script setup>
import {useBuildQuery} from '@/Composables/useBuildQuery.js'
import { ref } from 'vue'
const emit = defineEmits(['update:modelValue','changed']);
const showPopup = ref(false);
const loader = ref(false);
let props  = defineProps({
    status:String,
    filter:Object,
    url:String,
});
const parseDate = (str) => {
    if(!str) return '';
    var y = str.substr(0,4),
        m = str.substr(4,2) - 1,
        d = str.substr(6,2);
    var D = new Date(y,m,d);
    return (D.getFullYear() == y && D.getMonth() == m && D.getDate() == d) ? D : 'invalid date';
}
const opendate = ref([new Date(parseDate(props.filter.openedFrom)),new Date(parseDate(props.filter.openedTo))]);
const closedate = ref([new Date(parseDate(props.filter.closedFrom)),new Date(parseDate(props.filter.closedTo))]);
const params = ref({
    status:props.status,
    page:1,
    service:props.filter.service,
    customerTicket:props.filter.customerTicket,
    number:props.filter.number,
    openedFrom:props.filter.openedFrom,
    openedTo:props.filter.openedTo,
    closedFrom:props.filter.closedFrom,
    closedTo:props.filter.closedTo,
})

const reset = () => {
    opendate.value = null;
    closedate.value = null;
    params.value = {
        status:props.status,
        page:1,
        service:'',
        customerTicket:'',
        number:'',
        openedFrom:'',
        openedTo:'',
        closedFrom:'',
        closedTo:'',
    }
    emit('update:modelValue',props.url);
    emit('changed',props.url);
}
const close = () => {
    showPopup.value = false;
}

const firePopup = (data) => {
    showPopup.value = true;
}
const formatDate = (str) => {
    let date = new Date(str),
    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
    day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join('');
}
const handleDateOpen = (dates) => {
    params.value.openedFrom = formatDate(dates[0]);
    params.value.openedTo = formatDate(dates[1]);
}
const handleDateClose = (dates) => {
    params.value.closedFrom = formatDate(dates[0]);
    params.value.closedTo = formatDate(dates[1]);
}


const changeParams = (e) => {
    const endpoint = ref(useBuildQuery(route('ticket.index'),params.value));
    emit('update:modelValue', endpoint.value)
    emit('changed', endpoint.value)
}
defineExpose({ firePopup });



</script>
