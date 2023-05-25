<script setup>
import InputColor from '@/Admin/Components/Forms/InputColor.vue';
import {  useForm} from '@inertiajs/inertia-vue3';
import { ref } from 'vue'

const props  = defineProps({
    tag: Object,
    type: String,
    method:String,
});

const form = useForm(props.tag);

const submit = () => {
    if(props.method == 'store'){
        form.post(route('tag.store'), {
            preserveScroll: false,
            onFinish: () => form.reset(),
        });
    }
    if(props.method == 'update'){
        form.patch(route('tag.update',{'tag':props.tag.id}), {
            preserveScroll: false,
            onFinish: () => form.reset(),
        });
    }
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
        <div class="px-4">
          <form class="flex flex-col lg:flex-row mt-4 gap-5"  @submit.prevent="submit">
            <div class="w-8/12">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded" >
                    <div class="text-sm px-5 font-medium text-center  text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-blueGray-300">
                        <ul class="flex flex-wrap -mb-px">
                            <li class="mr-2" v-for="(locale,index) in $page.props.languages">
                                <a @click="changeLangTab(locale.text)" class="capitalize inline-block cursor-pointer font-bold px-5 py-5 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                :class="{'border-blue-600 text-blue-600 active dark:text-blue-500 dark:border-blue-500' : langtab == locale.text }"
                                aria-current="tag">{{ locale.text }}</a>
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
                                        aria-current="tag">Content</a>
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
                        <div class="block w-full overflow-x-auto px-7" :class="{hidden : tab != langtab+'-seo'}">
                                <div class="block">
                                    <InputLabel value="Meta Title" />
                                    <TextInput type="text" class="mt-1 block w-full" v-model="form.meta[locale.prefix].title"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel value="Meta Description" />
                                    <TextAreaInput  class="mt-1 block w-full" v-model="form.meta[locale.prefix].description"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel value="Meta Image" />
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
            <div class="w-4/12">
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded p-5" >

                    <div class="block mt-4">
                        <div class="flex items-center">
                            <Checkbox v-model:checked="form.featured" />
                            <InputLabel for="featured" value="Set as featured" class="!m-0 !ml-3" />
                        </div>
                        <InputError class="mt-2" :message="form.errors.featured" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel for="published_at" value="Published Date" />
                        <Datepicker v-model="form.published_at" format="dd/MM/yyyy" placeholder="Select Published Date" />
                        <InputError class="mt-2" :message="form.errors.published_at" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel for="bg_color" value="Background Color" />
                        <InputColor class="mt-1 block w-full" v-model="form.bg_color"  />
                        <InputError class="mt-2" :message="form.errors.bg_color" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel for="text_color" value="Text Color" />
                        <InputColor class="mt-1 block w-full" v-model="form.text_color"  />
                        <InputError class="mt-2" :message="form.errors.text_color" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel :for="form.images" value="Thumbnail" />
                        <acit-jazz-upload
                        class="mt-1 block w-full"
                        title="thumbnail"
                        folder="tag"
                        :limit="1"
                        filetype="image/*"
                        name="thumbnail"
                        v-model="form.images"
                        >
                        </acit-jazz-upload>
                    </div>
                </div>

            </div>
          </form>
        </div>
    </Admin>
</template>
