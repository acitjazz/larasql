<script setup>
import { usePage} from '@inertiajs/inertia-vue3';
import Admin from '@/Admin/Layouts/Admin.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref  } from 'vue'

let props  = defineProps({
    page: Object,
    data:Object,
    category:[Object,String],
});
const user = ref(usePage().props.value.auth.user);

</script>

<template>
    <Head title="Dashboard" />

    <Admin>
        <div class="p-5">

        </div>
    </Admin>
</template>

<script>
export default {
  props:['auth'],
};
</script>
