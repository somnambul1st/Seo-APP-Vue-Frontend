import './bootstrap'
import * as feather from 'feather-icons'
import { Dropdown } from 'bootstrap'

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

feather.replace();

import { createApp } from 'vue/dist/vue.esm-bundler.js'
import ProjectMetrics from "./components/ProjectMetrics.vue";
import { NTree, NDatePicker } from 'naive-ui'
import VueApexCharts from 'vue3-apexcharts'

const app = createApp({
    /* root component options */
})

app.component('project-metrics', ProjectMetrics)
app.component('n-tree', NTree)
app.component('n-date-picker', NDatePicker)
app.component('apexchart', VueApexCharts)
app.mount('#app')
