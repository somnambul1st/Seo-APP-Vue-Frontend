<template>
    <div class="row" v-if="!process">
        <div class="col-sm-9">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-8">
                            <button v-bind:class="{ 'btn-primary': display === 'avg', 'btn-primary-light': display !== 'avg' }" class="btn text-center me-2" @click="display = 'avg'" type="button">
                                Средняя
                            </button>
                            <button v-bind:class="{ 'btn-primary': display === 'top100', 'btn-primary-light': display !== 'top100' }" class="btn text-center me-2" @click="display = 'top100'" type="button">
                                Топ 100
                            </button>
                        </div>
                        <div class="col-sm-4"><n-date-picker v-model:value="range" type="daterange" :actions="null" :first-day-of-week="0" :update-value-on-close="true" /></div>
                    </div>

                    <div v-if="display === 'top100'">
                        <apexchart width="100%" :toolbar="false" height="400px" type="area" :options="chartOptionsTop100()" :series="chartSeriesTop100()"></apexchart>
                    </div>

                    <div v-if="display === 'avg'">
                        <apexchart width="100%" :toolbar="false" height="400px" type="area" :options="chartOptionsAvg()" :series="chartSeriesAvg()"></apexchart>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card h-100 pj-tree">
                <div class="card-body">
                    <div class="mb-3">
                        <button class="btn btn-primary m-r-10" @click="selectAll()">Выделить все</button>
                        <button class="btn btn-secondary" @click="deselectAll()">Снять все</button>
                    </div>

                    <n-tree
                        checkable
                        :data="categories_list"
                        @update:checked-keys="treeCheckedKeys"
                        :node-props="treeProps"
                        :checked-keys="selected_categories_list"
                    />

                    <n-dropdown
                        trigger="manual"
                        placement="bottom-start"
                        :show="showDropdown"
                        :options="[{label: 'Выбрать все группы', key: 'select'}, {label: 'Убрать все группы', key: 'deselect'}]"
                        :x="x"
                        :y="y"
                        @select="handleSelect"
                        @clickoutside="handleClickoutside"
                    />
                </div>
            </div>
        </div>
    </div>

    <div v-if="keywords.length > 0">
        <div class="card mt-4 p-4" style="width: fit-content;">
            <p><b>Суммарная частотность:</b></p>
            <div>
                Базовая: {{ sum.ws_base_frequency ?? 0 }}<br>
                Фразовая: {{ sum.ws_quote_frequency ?? 0 }}<br>
                Точная: {{ sum.ws_quote_point_frequency ?? 0 }}
            </div>
        </div>
    </div>

    <div v-if="metric_yandex_xml_nums.length > 0" class="widget-joins card widget-arrow mt-4">
        <div class="row">
            <div class="col-sm-2 pe-0 custom-border-right">
                <div class="media border-after-xs">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">Средняя</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricAvg() > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricAvg() < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricAvgCurrent() }}</span></h5>
                        <span class="mb-1">{{ metricAvg() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ps-0 custom-border-right">
                <div class="media">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">1 - 10</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricNum('1-10') > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricNum('1-10') < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricNumCurrent('1-10') }}</span></h5>
                        <span class="mb-1">{{ metricNum('1-10') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ps-0 custom-border-right">
                <div class="media">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">11 - 30</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricNum('11-30') > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricNum('11-30') < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricNumCurrent('11-30') }}</span></h5>
                        <span class="mb-1">{{ metricNum('11-30') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ps-0 custom-border-right">
                <div class="media">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">31 - 50</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricNum('31-50') > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricNum('31-50') < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricNumCurrent('31-50') }}</span></h5>
                        <span class="mb-1">{{ metricNum('31-50') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ps-0 custom-border-right">
                <div class="media">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">51 - 100</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricNum('51-100') > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricNum('51-100') < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricNumCurrent('51-100') }}</span></h5>
                        <span class="mb-1">{{ metricNum('51-100') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ps-0">
                <div class="media">
                    <div class="align-self-center me-3 text-start"><span class="widget-t mb-1">Yandex</span>
                        <h5 class="mb-0">100+</h5>
                    </div>
                    <div class="media-body align-self-center">
                        <svg v-if="metricNum('101+') < 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#24695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        <svg v-if="metricNum('101+') > 0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </div>
                    <div class="media-body">
                        <h5 class="mb-0"><span class="counter">{{ metricNumCurrent('101+') }}</span></h5>
                        <span class="mb-1">{{ metricNum('101+') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="keywords.length > 0">
        <div class="card mt-4" style="width: fit-content;">
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive" style="width: fit-content;">
                    <table class="table table-border-vertical">
                        <thead>
                        <tr>
                            <th>Запрос</th>
                            <th>
                                <select v-model="select_q">
                                    <option value="ws_base_frequency">WS Базовая</option>
                                    <option value="ws_quote_frequency">WS Фразовая</option>
                                    <option value="ws_quote_point_frequency">WS Точная</option>
                                </select>
                            </th>
                            <th v-for="d in keywords_header">
                                {{ d }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="keyword in keywords">
                            <td>{{ keyword['text'] }}</td>
                            <td>{{ keyword[select_q] ?? '-' }}</td>
                            <template v-for="(d, idx) in keywords_header">
                                <th v-bind:style="{'background-color': posColor(keyword['positions'][d], keyword['positions'][keywords_header[idx - 1]])}">
                                    {{ keyword['positions'][d] ?? '-' }}
                                </th>
                            </template>
                        </tr>
                        </tbody>
                    </table>

                    <div class="p-4">
                        <button v-if="pages > 1 && current_page < pages" class="btn btn-secondary" @click="appendLoadKeywords(current_page + 1)">Загрузить еще</button>
                        <p class="mt-2">Всего запросов: {{ keywords.length }} из {{ on_pages }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import ApexCharts from 'apexcharts'
//import VueApexCharts from 'vue-apexcharts'
// import * as feather from 'feather-icons'

export default {
    props: [
        "projectId", // current project id
        "minDay",
        "maxDay",
    ],

    data() {
        return {
            load_metrics: false,
            process: false, // loading flag
            display: 'avg',

            range: [this.minDay * 1000, this.maxDay * 1000],
            project_id: this.projectId,
            categories_list: [],
            selected_categories_list: [],

            metric_yandex_xml_nums: [],
            metric_yandex_xml_avg: [],

            keywords: [],
            keywords_header: [],
            sum: {
                ws_base_frequency: 0,
                ws_quote_frequency: 0,
                ws_quote_point_frequency: 0,
            },

            select_q: 'ws_base_frequency',

            showDropdown: false,
            x: 0,
            y: 0,
            mm: null,

            current_page: 1,
            pages: 1,
            on_pages: 0,
        }
    },

    mounted() {
        this.loadCategories()
        this.loadMetrics()
    },

    beforeUpdate() {
        //feather.replace();
    },

    watch: {
        range() {
            this.loadMetrics()
            this.loadKeywords()
        }
    },

    methods: {
        deselectAll() {
            let c = this
            c.selected_categories_list = []
            this.loadMetrics()
            this.loadKeywords()
        },

        selectAll() {
            let c = this
            let keys = []

            for (let i = 0; i < c.categories_list.length; i++) {
                keys = keys.concat(c.getKeys(c.categories_list[i]))
            }

            c.selected_categories_list = keys
            this.loadMetrics()
            this.loadKeywords()
        },

        handleSelect(key) {
            let c = this
            //console.log('select ' + key)
            c.showDropdown = false

            if (key === 'select') {
                c.selected_categories_list = c.selected_categories_list.concat(c.mm)
                this.loadMetrics()
                this.loadKeywords()
            }
            else if (key === 'deselect') {
                let all = [];
                for (let i = 0; i < c.selected_categories_list.length; i++) {
                    if (! c.mm.includes(c.selected_categories_list[i])) {
                        all.push(c.selected_categories_list[i])
                    }
                }
                c.selected_categories_list = all
                this.loadMetrics()
                this.loadKeywords()
            }

        },

        handleClickoutside() {
            let c = this
            c.showDropdown = false
        },

        getKeys(option) {
            let c = this
            let keys = []
            keys.push(option.key)

            if (option.children && option.children.length > 0) {
                //console.log(option.children)
                for (let i = 0; i < option.children.length; i++) {
                    //console.log(c.getKeys(option.children[i]))
                    keys = keys.concat(c.getKeys(option.children[i]))
                }
            }

            return keys
        },

        treeProps(option) {
            let c = this
            return {
                onClick() {
                    //console.info("[Click] " + option.label);
                },
                onContextmenu(e) {
                    //console.log(c.getKeys(option.option))
                    //console.log(option)
                    c.mm = c.getKeys(option.option)
                    c.showDropdown = true;
                    c.x = e.clientX;
                    c.y = e.clientY;
                    console.log(e.clientX, e.clientY, c.showDropdown);
                    e.preventDefault();
                }
            };
        },

        posColor(c, n) {
            c = parseInt(c) || 0
            n = parseInt(n) || 0

            if (c === 0) {
                return 'transparent';
            }
            if (n === 0) {
                return 'transparent';
            }

            if (c === n) {
                return 'transparent';
            }
            else if (c > n) {
                // red
                return 'rgba(255,0,0,'+((c-n)/100)+')'
            } else {
                // green
                return 'rgba(75,255,0,'+((n-c)/100)+')'
            }
        },

        metricAvg() {
            let last = this.metric_yandex_xml_avg.length - 1
            return this.metric_yandex_xml_avg[0]['avg'] - this.metric_yandex_xml_avg[last]['avg']
        },

        metricAvgCurrent() {
            let last = this.metric_yandex_xml_avg.length - 1
            return this.metric_yandex_xml_avg[last]['avg']
        },

        metricNum(per) {
            let last = this.metric_yandex_xml_nums.length - 1
            return this.metric_yandex_xml_nums[last][per] - this.metric_yandex_xml_nums[0][per]
        },

        metricNumCurrent(per) {
            let last = this.metric_yandex_xml_nums.length - 1
            return this.metric_yandex_xml_nums[last][per]
        },

        treeCheckedKeys(keys, options, meta) {
            this.selected_categories_list = keys
            this.loadMetrics()
            this.loadKeywords()
        },

        // treeProps: ({ option }) => {
        //     return {
        //         onClick() {
        //             //message.info("[Click] " + option.label);
        //         },
        //     };
        // },

        loadCategories() {
            let c = this
            c.process = true

            axios.get('/api/v1/project/'+c.project_id+'/categories', {})
                .then(function (response) {
                    c.categories_list = response.data.data
                    c.process = false
                })
                .catch(function (error) {
                    c.process = false
                });
        },

        loadMetrics() {
            let c = this
            c.load_metrics = true

            axios.get('/api/v1/project/'+c.project_id+'/metrics', {params: {'from': c.range[0], 'to': c.range[1], 'categories': c.selected_categories_list}})
                .then(function (response) {
                    c.metric_yandex_xml_nums = response.data.yandex_xml_nums
                    c.metric_yandex_xml_avg = response.data.yandex_xml_avg
                    c.load_metrics = false
                    c.sum = response.data.ws_sum

                    //console.log(c.metric_yandex_xml_nums)
                })
                .catch(function (error) {
                    c.load_metrics = false
                });
        },

        loadKeywords(page = 1) {
            let c = this
            //c.load_metrics = true

            if (c.selected_categories_list.length > 0) {
                axios.get('/api/v1/project/'+c.project_id+'/keywords', {params: {'page': page, 'from': c.range[0], 'to': c.range[1], 'categories': c.selected_categories_list}})
                    .then(function (response) {
                        //c.load_metrics = false
                        //console.log(c.metric_yandex_xml_nums)
                        c.keywords = response.data.data.data
                        c.keywords_header = response.data.header

                        // paginator
                        c.current_page = response.data.data.current_page
                        c.pages = response.data.data.last_page
                        c.on_pages = response.data.data.total
                    })
                    .catch(function (error) {
                        c.keywords = []
                        c.keywords_header = []
                        c.current_page = 1
                        c.pages = 1
                        c.on_pages = 0
                    });
            } else {
                c.keywords = []
                c.keywords_header = []
                c.current_page = 1
                c.pages = 1
                c.on_pages = 0
            }
        },

        appendLoadKeywords(page = 1) {
            let c = this
            //c.load_metrics = true

            if (c.selected_categories_list.length > 0) {
                axios.get('/api/v1/project/'+c.project_id+'/keywords', {params: {'page': page, 'from': c.range[0], 'to': c.range[1], 'categories': c.selected_categories_list}})
                    .then(function (response) {
                        //c.load_metrics = false
                        //console.log(c.metric_yandex_xml_nums)
                        c.keywords = c.keywords.concat(response.data.data.data)

                        // paginator
                        c.current_page = response.data.data.current_page
                        c.pages = response.data.data.last_page
                        c.on_pages = response.data.data.total
                    })
                    .catch(function (error) {});
            }
        },

        chartOptionsTop100() {
            let categories = [];

            this.metric_yandex_xml_nums.forEach(function (item) {
                categories.push(item['date'])
            })

            return {
                xaxis: {
                    categories: categories,
                },
                yaxis: {
                    labels: {
                        formatter: (value) => {
                            return value.toFixed(0)
                        },
                    }
                },
                chart: {
                    toolbar: { show: false },
                    fontFamily: 'Nunito, sans-serif',
                },
                dataLabels: {
                    enabled: false
                },
                colors:['#24695c', '#1abc9c', '#2e96dd', '#b0c7c7', '#fbc02d']
            }
        },

        chartSeriesTop100() {
            let tmp1 = []; // 1-10
            let tmp2 = []; // 11-30
            let tmp3 = []; // 31-50
            let tmp4 = []; // 51-100
            let tmp5 = []; // 101+

            this.metric_yandex_xml_nums.forEach(function (item) {
                tmp1.push(item['1-10'])
                tmp2.push(item['11-30'])
                tmp3.push(item['31-50'])
                tmp4.push(item['51-100'])
                tmp5.push(item['101+'])
            })

            return [{name: '1-10', data: tmp1}, {name: '11-30', data: tmp2}, {name: '31-50', data: tmp3}, {name: '51-100', data: tmp4}, {name: '101+', data: tmp5}];
        },

        chartOptionsAvg() {
            let categories = [];

            this.metric_yandex_xml_avg.forEach(function (item) {
                categories.push(item['date'])
            })

            return {
                xaxis: {
                    categories: categories,
                },
                yaxis: {
                    reversed: true,
                    // opposite: true,
                    labels: {
                        formatter: (value) => {
                            return value.toFixed(0)
                        },
                    }
                },
                chart: {
                    toolbar: { show: false },
                    fontFamily: 'Nunito, sans-serif',
                },
                dataLabels: {
                    enabled: false
                },
                colors:['#24695c']
            }
        },

        chartSeriesAvg() {
            let tmp1 = []; // 1-10

            this.metric_yandex_xml_avg.forEach(function (item) {
                tmp1.push(item['avg'])
            })

            return [{name: 'Средняя позиция', data: tmp1}];
        },
    }
}
</script>

