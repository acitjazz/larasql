<script setup>
import ApplicationLogo from '@/Admin/Components/ApplicationLogo.vue';
import Guest from '@/Admin/Layouts/Guest.vue';
import InputError from '@/Admin/Components/Forms/InputError.vue';
import InputLabel from '@/Admin/Components/Forms/InputLabel.vue';
import Checkbox from '@/Admin/Components/Forms/Checkbox.vue';
//import { useReCaptcha } from "vue-recaptcha-v3";
import PrimaryButton from '@/Admin/Components/Buttons/PrimaryButton.vue';
import TextInput from '@/Admin/Components/Forms/TextInput.vue';

import {ref} from 'vue';
import { Head, Link, useForm ,usePage} from '@inertiajs/vue3';
// const { executeRecaptcha, recaptchaLoaded } = useReCaptcha()
let props  = defineProps({
    pics: Object,
    roles: Object,
    countrys:Object,
});

const form = useForm({
    name: '',
    last_name:'',
    email: '',
    roles:[],
    country: '',
    company: '',
    phone: '',
    phone_code: '',
    pic:'',
    captcha_token :null,
});
const rolesdata = ref('');
const rolesdataarr = ref([]);

const updateRole = (e,r) => {
    if (e.target.checked) {
        const role = [r.value];
        form.roles = [...new Set([...form.roles,...role])];
    }else{
        form.roles.splice(form.roles.indexOf(r.value), 1);
    }
}
const changeCountry = (e) => {
    if(e.target.value){
          let country =  props.countrys.find(c => c.name == e.target.value);
          form.phone_code = country.phone_code;
    }
};
// const submit = () => {
//     form.post(route('register'), {

//     });
// };

function submit(e) {
        grecaptcha.ready(function() {
          grecaptcha.execute('6Ld3PBImAAAAAA_zzdnsOCw81mZHo6h_zODHtDFQ', {action: 'submit'}).then(function(token) {
              // Add your logic to submit to your backend server here.
              form.captcha_token = token;

                form.post(route('register.post'), {
                    preserveScroll: false,
                    preserveState:true,
                    onFinish: () => {

                        console.log(res)
                    },
                    onSuccess: (res) => {
                    console.log(res)
                    },
                    onError: (res) => {
                    console.log(res)
                    },
                });
          });
        });
}
</script>

<template>
    <Guest>
        <Head title="Register" />
        <div class="flex flex-wrap max-w-[800px] mx-auto w-full p-5 lg:p-10 min-h-screen">
            <div class="p-5 lg:p-10 w-full flex flex-col justify-center" >
                <Link href="/">
                        <ApplicationLogo class="h-14 fill-current text-gray-500" />
                </Link>

                <h3 class="font-semibold text-3xl mt-10">Register</h3>
                <p>It's quick and easy.</p>

                <form @submit.prevent="submit">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">First Name</legend>

                            <TextInput
                                id="name"
                                type="text"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="$page.props.errors.name" />
                        </div>
                        <div class="sm:col-span-3">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">Last Name</legend>
                            <TextInput
                                id="last_name"
                                type="text"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="form.last_name"
                                autofocus
                                autocomplete="last_name"
                            />

                            <InputError class="mt-2" :message="$page.props.errors.last_name" />
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">Company Name</legend>

                            <TextInput
                                id="company"
                                type="text"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="form.company"
                                autocomplete="company"
                            />

                            <InputError class="mt-2" :message="$page.props.errors.company" />
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">Company Email Address</legend>

                            <TextInput
                                id="email"
                                type="email"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                v-model="form.email"
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="$page.props.errors.email" />
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">Country</legend>
                            <select
                                name="country"
                                autocomplete="country-name"
                                v-model="form.country"
                                @change="changeCountry"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                 <option
                                            v-for="country in countrys"
                                            :key="country.id"
                                            :value="country.name"
                                            selected
                                        >

                                            {{ country.name }}
                                        </option>

                                </select>

                                <InputError class="mt-2" :message="$page.props.errors.country" />
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 ">Phone Number</legend>
                            <div class="flex gap-2">
                                <TextInput
                                    id="phone_code"
                                    type="text"
                                    class="block w-1/12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    v-model="form.phone_code"

                                    autocomplete="phone_code"
                                />
                                <TextInput
                                    id="phone"
                                    type="number"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                    v-model="form.phone"
                                    autocomplete="phone"
                                />
                            </div>
                            <InputError class="mt-2" :message="$page.props.errors.phone_code" />
                            <InputError class="mt-2" :message="$page.props.errors.phone" />
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 flex">Roles
                                <Tooltip template="reg_roles"></Tooltip>
                            </legend>

                            <div class="mt-6 flex items-center gap-5 flex-wrap">
                                <div class="relative"
                                    v-for="role in roles"
                                    :key="role.row"
                                >
                                <div class="flex items-center">
                                    <div class="mr-2">
                                        <TextInput
                                            type="checkbox"
                                            class="h-4 w-4 mb-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                            v-model="rolesdata"
                                            @click="updateRole($event,role)"
                                            :value="role.value"
                                            autocomplete="roles"
                                        />
                                    </div>
                                    <div class="text-sm leading-6">
                                        <InputLabel for="email" :value="role.label"/>
                                    </div>
                                </div>
                                </div>
                                     <InputError class="mt-2" :message="$page.props.errors.roles" />
                            </div>
                        </div>
                        <div class="sm:col-span-6">
                            <legend class="text-sm font-semibold leading-6 text-gray-900 flex">PIC
                                <Tooltip template="reg_pic_telin"></Tooltip>
                            </legend>

                            <select
                                id="pic"
                                name="pic"
                                autocomplete="pic-name"
                                v-model="form.pic"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                 <option
                                            v-for="pic in pics"
                                            :key="pic.id"
                                            :value="pic.id"
                                            selected
                                        >

                                            {{ pic.name }}
                                        </option>
                                </select>

                            <InputError class="mt-2" :message="$page.props.errors.pic" />
                        </div>
                    </div>
                        <div>
                        <InputError class="mt-2" :message="$page.props.errors.captcha_token" />
                        </div>
                    <div class="flex items-center justify-end mt-4">
                            <Link
                                :href="route('login')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Already registered?
                            </Link>

                            <button as="button" type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-primary border
                        border-transparent rounded-md font-semibold text-xs text-white
                        hover:bg-gray-700 active:bg-gray-900
                        focus:outline-none focus:border-gray-900 focus:shadow-outline-gray
                        transition ease-in-out duration-150" :class="{ 'opacity-25': form.processing }"    :disabled="form.processing">
                                Register
                            </button>
                    </div>
                </form>
            </div>
        </div>
    </Guest>
</template>
