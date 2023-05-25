<script setup>

import InputNavigation from '@/Admin/Components/Forms/InputNavigation.vue';
import {  useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'

const props  = defineProps({
    page: Object,
});

const form = useForm(props.page);

const submit = () => {
    form.patch(route('page.update',{'page':props.page.id}), {
        preserveScroll: false,
        onFinish: () => form.reset(),
    });
};

const tab = ref('english-content')
const langtab = ref('english')
const changeTab = ( newtab) => {
    tab.value = newtab;
}
const changeLangTab = (newtab) => {
    langtab.value = newtab;
    tab.value = newtab+'-content';
}

</script>

<template>
    <Head title="Content" />
    <Admin>
        <div>
          <form class="flex flex-wrap mt-4"  @submit.prevent="submit">
            <div class="w-full px-4">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded" >
                    <div class="text-sm px-5 font-medium text-center  text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-blueGray-300">
                        <ul class="flex flex-wrap -mb-px">
                            <li class="mr-2" v-for="(locale,index) in $page.props.languages">
                                <a @click="changeLangTab(locale.text)" class="capitalize inline-block cursor-pointer font-bold px-5 py-5 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                :class="{'border-blue-600 text-blue-600 active dark:text-blue-500 dark:border-blue-500' : langtab == locale.text }"
                                aria-current="page">{{ locale.text }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="block w-full overflow-x-auto" v-for="(locale,index) in $page.props.languages" :class="{hidden : langtab != locale.text}">

                        <div class="block w-full overflow-x-auto px-7 py-5">
                            <InputNavigation v-model="form.contents[locale.prefix]"></InputNavigation>
                        </div>
                    </div>
                    <div class="mt-10">
                        <PrimaryButton  @click="submit" class="w-full block text-center py-3 px-3 justify-center rounded-none rounded-b-md" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </Admin>
</template>
