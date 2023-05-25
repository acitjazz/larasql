<script setup>
import ApplicationLogo from '@/Admin/Components/ApplicationLogo.vue';
import Guest from '@/Admin/Layouts/Guest.vue';
import { Head, Link} from '@inertiajs/vue3';
let props  = defineProps({
    title: String,
    message: String,
});

</script>

<template>
    <Guest>
        <Head title="Register" />
        <div class="flex flex-wrap flex-col items-center max-w-[800px] mx-auto w-full p-5 lg:p-10 min-h-screen justify-center">
            <div class="p-5 mb-10" >
                <Link href="/" class="text-center flex justify-center">
                        <ApplicationLogo class="h-14 fill-current text-gray-500" />
                </Link>
            </div>
            <div class="text-center max-w-[500px] mx-auto mb-10">
                <h1 class="font-bold text-xl">{{ title }}</h1>
                <p>{{ message }}</p>
            </div>
            <Link  :href="route('login')" class="ml-4 inline-flex items-center px-4 py-2 bg-primary border
            border-transparent rounded-md font-semibold text-xs text-white
            hover:bg-gray-700 active:bg-gray-900
            focus:outline-none focus:border-gray-900 focus:shadow-outline-gray
            transition ease-in-out duration-150">
                Login
        </Link>
        </div>
    </Guest>
</template>
