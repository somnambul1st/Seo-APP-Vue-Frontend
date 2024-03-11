import './bootstrap'
import { Dropdown } from 'bootstrap'

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from './layouts/Layout.vue'
import { NTree, NDatePicker, NDropdown } from 'naive-ui'
import VueApexCharts from 'vue3-apexcharts'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
        let page = pages[`./pages/${name}.vue`]
        page.default.layout = page.default.layout || Layout
        return page
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('n-tree', NTree)
            .component('n-date-picker', NDatePicker)
            .component('apexchart', VueApexCharts)
            .component('n-dropdown', NDropdown)
            .mount(el)
    },
})
