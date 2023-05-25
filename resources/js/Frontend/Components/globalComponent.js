

import { defineAsyncComponent } from 'vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
const Master = defineAsyncComponent(
    () => import('@/Frontend/Layouts/Master.vue')
)
const Container = defineAsyncComponent(
    () => import('@/Frontend/Components/Html/Container.vue')
)
export default {
    install (Vue) {
        Vue.component('Master', Master),
        Vue.component('Container', Container),
        Vue.component('Head', Head)
        Vue.component('Link', Link)
    }
}
