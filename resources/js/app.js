import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import 'vue-toastification/dist/index.css';
import Toast from 'vue-toastification';

const options = {}


createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .mixin({methods: { route }})
      .use(Toast, options)
      .use(plugin)
      .mount(el)
  },
});
