<script setup>

import { Head, Link, useForm ,usePage} from '@inertiajs/inertia-vue3';
import { onMounted, ref,watch } from 'vue'

let props  = defineProps({
    administrators: Object,
    type: String,
    auth: Object,
    method:String,
});

const form = useForm(props.administrators);

form.password='';
onMounted(() => {
    form.type = props.type
});

const submit = () => {
    if(props.method == 'store'){
        console.log(route('administrator.store',form.id));
        form.post(route('administrator.store',form.id), {
                preserveScroll: false,
                onSuccess: (res) => {

                },
            });


    }
    if(props.method == 'update'){
        console.log('update')
         console.log(route('administrator.update',{administrator: props.administrators}))
        form.patch(route('administrator.update',{administrator: props.administrators}), {
            preserveScroll: false,
            onFinish: () => form.reset(),
            onSuccess: (res) => {

            },
        });
    }
};

const tab = ref('content')
const changeTab = ( newtab) => {
    tab.value = newtab;
}

</script>

<template>
    <Head title="Content" />
    <Admin>
        <div>
          <form class="flex flex-wrap mt-4"  @submit.prevent="submit">
            <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded" >
                    <div class="rounded-t mb-0 px-7 py-5 border-1">
                        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-blueGray-300">
                            <ul class="flex flex-wrap -mb-px">
                                <li class="mr-2">
                                    <a @click="changeTab('content')" class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                    :class="{'border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == 'content'}"
                                    aria-current="content">Administrator</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="block w-full px-7 py-5" :class="{hidden : tab != 'content'}">

                        <div class="block">
                            <InputLabel for="username" value="User Name" />

                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"  autofocus />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="block mt-4">
                            <InputLabel for="bod" value="Bith of Date" />
                            <Datepicker v-model="form.bod" format="dd/MM/yyyy" placeholder="Select Bith of Date" />
                            <InputError class="mt-2" :message="form.errors.bod" />
                        </div>

                        <div class="block mt-4">
                            <InputLabel for="email" value="Email" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"  autofocus />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                          <div class="block mt-4">
                            <div class="flex items-center">
                                <InputLabel for="password" class="!m-0" value="Password" />
                                <Tooltip :custom="true" :data="{message:'The password field must contain at least one uppercase, one lowercase letter, special character, number and minimum 8 characters, also not contain your name or your birthday'}"></Tooltip>
                            </div>
                            <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"  autofocus />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="block mt-4">
                            <div class="flex items-center">
                                <InputLabel for="repassword" class="!m-0" value="Re-Password" />
                                <Tooltip :custom="true" :data="{message:'The password field must contain at least one uppercase, one lowercase letter, special character, number and minimum 8 characters, also not contain your name or your birthday'}"></Tooltip>
                            </div>
                            <TextInput id="repassword" type="password" class="mt-1 block w-full" v-model="form.repassword"  autofocus />
                            <InputError class="mt-2" :message="form.errors.repassword" />
                        </div>

                    </div>

                    <div class="mt-10">
                        <PrimaryButton   @click="submit" class="w-full block text-center py-3 px-3 justify-center rounded-none rounded-b-md" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </div>
            </div>

          </form>
        </div>
    </Admin>
</template>
