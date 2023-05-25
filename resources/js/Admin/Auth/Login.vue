<script setup>
import Guest from '@/Admin/Layouts/Guest.vue';
import InputError from '@/Admin/Components/Forms/InputError.vue';
import PrimaryButton from '@/Admin/Components/Buttons/PrimaryButton.vue';
import TextInput from '@/Admin/Components/Forms/TextInput.vue';
import ApplicationLogo from '@/Admin/Components/ApplicationLogo.vue';
import { ref  } from 'vue'

import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    errors: Object,

});
const showPassword =  ref(false);
const showForm = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
    captcha_token: '',
});
function submit(e) {
        grecaptcha.ready(function() {
          grecaptcha.execute('6Ld3PBImAAAAAA_zzdnsOCw81mZHo6h_zODHtDFQ', {action: 'submit'}).then(function(token) {
              // Add your logic to submit to your backend server here.
              form.captcha_token = token;

                form.post(route('admin.login'), {
                    onFinish: () => form.reset('password'),
                });
          });
        });
}

const showLogin = (val) => {
    showForm.value = val;
};

</script>

<template>
    <Guest>
        <Head title="Log in" />
        <div class="flex flex-wrap w-full p-5 lg:p-10 min-h-screen">
            <div class="p-5 lg:p-10 w-full lg:w-7/12  flex flex-col justify-center mx-auto">
                    <Link :href="route('home')">
                        <ApplicationLogo class="h-14 fill-current text-gray-500" />
                    </Link>

                    <h3 class="font-semibold text-3xl mb-5 mt-10">Backend Started</h3>
                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>
                    <form @submit.prevent="submit">
                        <div class="mt-10">
                            <TextInput
                                id="email"
                                type="email"
                                placeholder="Email"
                                class="mt-1 block w-full rounded-none"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                            />

                        </div>

                        <div class="mt-7">
                            <div class="relative">
                                <TextInput
                                    id="password"
                                    :type="(showPassword ? 'text' : 'password')"
                                    placeholder="Password"
                                    class="mt-1 block w-full rounded-none"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                />
                                <i class="fa absolute right-3 top-3 cursor-pointer" :class="[{'fa-eye' : showPassword},{'fa-eye-slash' : !showPassword}]" @click="showPassword = !showPassword"></i>
                            </div>

                            <InputError class="mt-2" :message="errors.email" />
                        </div>
                        <div class="mt-10 mb-5">
                            <PrimaryButton preserve-state as="button" type="submit" @click="submit" class="rounded-none w-full text-center justify-center py-3 px-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Log in
                            </PrimaryButton>
                            <br />

                        </div>
                    </form>
                    <small class="text-gray-500 text-center block mt-3">{{ new Date().getFullYear() }} {{ $page.props.env.app_name }} , All Right Reserved</small>
            </div>
        </div>
    </Guest>
</template>
