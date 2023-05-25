import './bootstrap';
import '../scss/admin.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";
import globalComponent from "@/Admin/Components/globalComponent";
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { VTooltip,Menu,Dropdown} from 'floating-vue';
import 'floating-vue/dist/style.css'
import Vue3Tour from 'vue3-tour'
import 'vue3-tour/dist/vue3-tour.css'


const appName =  'My Telin';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Admin/${name}.vue`, import.meta.glob('./Admin/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(globalComponent)
            .use(ZiggyVue, Ziggy)
            .use(Vue3Tour)
            .component('VMenu', Menu)
            .component('VDropdown', Dropdown)
            .directive('tooltip', VTooltip)
            .mount(el);
    },
});
InertiaProgress.init({ color: '#E9001A' });
