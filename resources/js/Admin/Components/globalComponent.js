
import { defineAsyncComponent } from 'vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import { Draggable } from "@he-tree/vue";

const Admin = defineAsyncComponent(
    () => import('@/Admin/Layouts/Admin.vue')
)
const Checkbox = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/Checkbox.vue')
)
const InputError = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputError.vue')
)
const InputLabel = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputLabel.vue')
)

const TextInput = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/TextInput.vue')
)

const AcitJazzUpload = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/AcitJazzUpload.vue')
)

const InputBanners = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputBanners.vue')
)

const TinyEditor = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/TinyEditor.vue')
)

const InputSlug = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputSlug.vue')
)

const InputSelect = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputSelect.vue')
)
const InputFeature = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputFeature.vue')
)
const InputGallery = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputGallery.vue')
)
const InputContentDesc = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputContentDesc.vue')
)
const InputTitleNumber = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/InputTitleNumber.vue')
)
const TextAreaInput = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/TextAreaInput.vue')
)
const Loader = defineAsyncComponent(
    () => import('@/Admin/Components/Forms/Loader.vue')
)

const Tooltip = defineAsyncComponent(
    () => import('@/Admin/Components/Popups/Tooltip.vue')
)
const Td = defineAsyncComponent(
    () => import('@/Admin/Components/Tables/Td.vue')
)
const Th = defineAsyncComponent(
    () => import('@/Admin/Components/Tables/Th.vue')
)
const SecondaryLink = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/SecondaryLink.vue')
)
const PrimaryButton = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/PrimaryButton.vue')
)
const APrimaryButton = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/APrimaryButton.vue')
)
const OutlineButton = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/OutlineButton.vue')
)
const AOutlineButton = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/AOutlineButton.vue')
)
const Badge = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/Badge.vue')
)
const Pagination = defineAsyncComponent(
    () => import('@/Admin/Components/Buttons/Pagination.vue')
)
export default {
    install (Vue) {
        Vue.component('Draggable', Draggable),
        Vue.component('Admin', Admin),
        Vue.component('Checkbox', Checkbox),
        Vue.component('InputError', InputError),
        Vue.component('InputLabel', InputLabel),
        Vue.component('TextAreaInput', TextAreaInput),
        Vue.component('PrimaryButton', PrimaryButton),
        Vue.component('APrimaryButton', APrimaryButton),
        Vue.component('Badge', Badge),
        Vue.component('OutlineButton', OutlineButton),
        Vue.component('AOutlineButton', AOutlineButton),
        Vue.component('TextInput', TextInput),
        Vue.component('AcitJazzUpload', AcitJazzUpload),
        Vue.component('InputBanners', InputBanners),
        Vue.component('TinyEditor', TinyEditor),
        Vue.component('InputSlug', InputSlug),
        Vue.component('InputSelect', InputSelect),
        Vue.component('InputFeature', InputFeature),
        Vue.component('InputGallery', InputGallery),
        Vue.component('InputContentDesc', InputContentDesc),
        Vue.component('InputTitleNumber', InputTitleNumber),
        Vue.component('Tooltip', Tooltip),
        Vue.component('Loader', Loader),

        //Table Component
        Vue.component('Td', Td),
        Vue.component('Th', Th),
        Vue.component('SecondaryLink', SecondaryLink),
        Vue.component('Pagination', Pagination)
        Vue.component('Head', Head)
        Vue.component('Link', Link)
    }
}
