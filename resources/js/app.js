import './bootstrap';
import '../scss/app.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";
import globalComponent from "@/Frontend/Components/globalComponent";
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';


const appName = 'My Telin';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Frontend/${name}.vue`, import.meta.glob('./Frontend/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(globalComponent)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
});
InertiaProgress.init({ color: '#E9001A' });
