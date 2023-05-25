<script setup>
const props  = defineProps({
    posts: Object,
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
                                    <OutlineButton v-for="(lang,index) in $page.props.languages" :key="index" class="capitalize" :href="route('post.index')"  :data="{ page:1, locale:lang.prefix, type:type }" :class="{'bg-active':locale == lang.prefix}">{{ lang.text }}</OutlineButton>
                                </div>
                            </div>
                            <div class="ml-auto">
                              <SecondaryLink  :href="route('post.create', { type:type })" class="px-3 py-1 rounded-none rounded-l-md">Create New</SecondaryLink>
                              <SecondaryLink  :href="route('post.index', { type:type, trash:'1' })" class="px-3 py-1 rounded-none rounded-r-md bg-red-500">Trash</SecondaryLink>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr>
                        <Th></Th>
                        <Th>Title</Th>
                        <Th>Published Date</Th>
                        <Th></Th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(post,index) in posts.data" :key="index" class="hover:bg-gray-100">
                        <Td width="100"><img :src="post.image"></Td>
                        <Td>{{post.title}}</Td>
                        <Td>{{post.published_at}}</Td>
                        <Td>
                            <div v-if="trash">
                                <SecondaryLink v-tooltip="'Restore'" class="px-3 py-2 bg-green-500 rounded-none rounded-l-md" :href="route('post.restore', { type:type, post:post })" method="post" as="button">
                                    <i class="fas fa-rotate-right"></i>
                                </SecondaryLink>
                                <SecondaryLink v-tooltip="'Destroy'" class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('post.forceDelete', { type:type, post:post })" method="post" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                            <div v-else>
                                <SecondaryLink v-tooltip="'Edit'" class="px-3 py-2 bg-indigo-500 rounded-none rounded-l-md" :href="route('post.edit', { type:type, post:post })">
                                    <i class="fas fa-pencil"></i>
                                </SecondaryLink>
                                <SecondaryLink v-tooltip="'Delete'"  class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('post.delete', { type:type, post:post })" method="post" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                        </Td>
                    </tr>
                    </tbody>
                </table>
                 <pagination class="mt-6" :links="posts.meta.links" />
                </div>
            </div>
         </div>
       </div>
   </Admin>
 </template>
