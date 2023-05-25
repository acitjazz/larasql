<script setup>

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
          <form class="flex flex-wrap mt-4">
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
                        <div class="rounded-t mb-5 px-5 border-1">
                            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-blueGray-300">
                                <ul class="flex flex-wrap -mb-px">
                                    <li class="mr-2">
                                        <a @click="changeTab(langtab+'-content')" class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == langtab+'-content'}"
                                        aria-current="page">Content</a>
                                    </li>
                                    <li class="mr-2">
                                        <a @click="changeTab(langtab+'-banners')"  class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == langtab+'-banners'}"
                                        >Banners</a>
                                    </li>
                                    <li class="mr-2">
                                        <a @click="changeTab(langtab+'-sections')"  class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == langtab+'-sections'}"
                                        >Sections</a>
                                    </li>
                                    <li class="mr-2">
                                        <a @click="changeTab(langtab+'-seo')"  class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == langtab+'-seo'}"
                                        >SEO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="block w-full overflow-x-auto px-7" :class="{hidden : tab != langtab+'-content'}">
                            <div class="block">
                                <InputLabel for="title" value="Title" />
                                <TextInput type="text" class="mt-1 block w-full" v-model="form.title[locale.prefix]"  />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="block mt-4">
                                <InputLabel for="slug" value="Slug" />
                                <InputSlug  type="text" class="mt-1 block w-full" :source="form.title[locale.prefix]" v-model="form.slug[locale.prefix]"  />
                                <InputError class="mt-2" :message="form.errors.slug" />
                            </div>

                            <div class="block mt-4">
                                <InputLabel for="summary" value="Summary" />
                                <TextAreaInput class="mt-1 block w-full" v-model="form.summary[locale.prefix]"  />
                                <InputError class="mt-2" :message="form.errors.summary" />
                            </div>
                        </div>
                        <div class="block w-full overflow-x-auto px-7" :class="{hidden : tab != langtab+'-banners'}">
                            <InputBanners v-model="form.banners[locale.prefix]"></InputBanners>
                        </div>
                        <div class="block w-full px-7" :class="{hidden : tab != langtab+'-sections'}">
                            <SelectSection v-model="form.sections[locale.prefix]"></SelectSection>
                        </div>
                        <div class="block w-full overflow-x-auto px-7" :class="{hidden : tab != langtab+'-seo'}">
                                <div class="block">
                                    <InputLabel :for="form.meta[locale.prefix].title" value="Meta Title" />
                                    <TextInput type="text" class="mt-1 block w-full" v-model="form.meta[locale.prefix].title"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel :for="form.meta[locale.prefix].description" value="Meta Description" />
                                    <TextAreaInput  class="mt-1 block w-full" v-model="form.meta[locale.prefix].description"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel :for="form.meta[locale.prefix].image" value="Meta Image" />
                                    <acit-jazz-upload
                                    class="mt-1 block w-full"
                                    title="meta"
                                    folder="tag"
                                    :limit="1"
                                    filetype="image/*"
                                    name="meta"
                                    v-model="form.meta[locale.prefix].image"
                                    >
                                    </acit-jazz-upload>
                                </div>
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
