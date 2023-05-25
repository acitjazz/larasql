import { createSSRApp, h } from 'vue';
import { renderToString } from '@vue/server-renderer';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import createServer from '@inertiajs/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import globalComponent from "@/Frontend/Components/globalComponent";
import '../scss/app.scss';

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `Telin | ${title}`,
        resolve: (name) => resolvePageComponent(`./Frontend/${name}.vue`, import.meta.glob('./Frontend/**/*.vue')),
        setup({ el, app, props, plugin }) {
            return createSSRApp({ render: () => h(app, props) })
                .use(plugin)
                .use(globalComponent)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                })
                .mount(el);
        },
    })

);

