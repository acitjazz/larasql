<template>
 <div class="w-3 ml-2">
    <VMenu>
    <button>  <i class="fa fa-circle-question text-primary ml-auto text-xs cursor-pointer"></i></button>
    <template #popper>
        <div v-if="custom">
            <p>{{ data.message }}</p>
        </div>
        <div v-else>
            <h5>{{ $page.props.tooltips.data.find(t => t.template === template).title }}</h5>
            <p>{{ $page.props.tooltips.data.find(t => t.template === template).description }}</p>
            <a v-if="$page.props.tooltips.data.find(t => t.template === template).url" :href="$page.props.tooltips.data.find(t => t.template === 'reg_roles').url" target="_blank">Learn More</a>
        </div>
    </template>
    </VMenu>
    </div>
</template>

<script setup>
let props  = defineProps({
    template: String,
    custom:Boolean,
    data:Object,
});
</script>
