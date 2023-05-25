<script setup>
const props  = defineProps({
    tags: Object,
    type: String,
    locale:String,
    title:String,
    trash:Boolean,
});
</script>

<template>
    <Head title="Dashboard" />
    <Admin>
       <div class="flex flex-wrap mt-4">
         <div class="w-full mb-12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                <div class="rounded-t mb-0 px-6 py-4 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full max-w-full flex">
                            <div class="flex items-center">
                                <h3 class="font-bold text-lg">
                                    {{title}}
                                </h3>
                                <div class="ml-5 flex gap-2 items-center flex-wrap">
                                    <OutlineButton v-for="(lang,index) in $page.props.languages" :key="index" class="capitalize" :href="route('tag.index')"  :data="{ page:1, locale:lang.prefix, type:type }" :class="{'bg-active':locale == lang.prefix}">{{ lang.text }}</OutlineButton>
                                </div>
                            </div>
                            <div class="ml-auto">
                              <SecondaryLink  :href="route('tag.create', { type:type })" class="px-3 py-1 rounded-none rounded-l-md">Create New</SecondaryLink>
                              <SecondaryLink  :href="route('tag.index', { type:type, trash:'1' })" class="px-3 py-1 rounded-none rounded-r-md bg-red-500">Trash</SecondaryLink>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr>
                        <Th>Title</Th>
                        <Th>Featured</Th>
                        <Th>Published Date</Th>
                        <Th></Th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(tag,index) in tags.data" :key="index" class="hover:bg-gray-100">
                        <Td><Badge :style="`background-color:${tag.bg_color}`"><span :style="`color:${tag.text_color};`">{{tag.title[locale]}}</span></Badge></Td>
                        <Td><Badge class="bg-blue-400 text-white !py-1 !px-2 text-xs" :class="{'!bg-primary' : tag.featured}">{{ tag.featured ? 'Featured' : 'Default' }}</Badge></Td>
                        <Td>{{tag.published_at}}</Td>
                        <Td>
                            <div v-if="trash">
                                <SecondaryLink v-tooltip="'Restore'" class="px-3 py-2 bg-green-500 rounded-none rounded-l-md" :href="route('tag.restore', { type:type, tag:tag })" method="tag" as="button">
                                    <i class="fas fa-rotate-right"></i>
                                </SecondaryLink>
                                <SecondaryLink v-tooltip="'Destroy'" class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('tag.forceDelete', { type:type, tag:tag })" method="tag" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                            <div v-else>
                                <SecondaryLink v-tooltip="'Edit'" class="px-3 py-2 bg-indigo-500 rounded-none rounded-l-md" :href="route('tag.edit', { type:type, tag:tag })">
                                    <i class="fas fa-pencil"></i>
                                </SecondaryLink>
                                <SecondaryLink v-tooltip="'Delete'"  class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('tag.delete', { type:type, tag:tag })" method="tag" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                        </Td>
                    </tr>
                    </tbody>
                </table>
                 <pagination class="mt-6" :links="tags.meta.links" />
                </div>
            </div>
         </div>
       </div>
   </Admin>
 </template>
