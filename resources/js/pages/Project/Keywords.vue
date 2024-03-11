<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted } from "vue";
import { NTree, NTreeSelect, NModal, NCard, NInput, NButton } from 'naive-ui'

const props = defineProps({ user: Object, project: Object })

const categories_list = ref([])
const selected_categories_list = ref([])
const keywords = ref([])
const treeProps = ref(null)

function treeCheckedKeys(keys, options, meta) {
    selected_categories_list.value = keys
    loadKeywords()
}

function loadCategories() {
    axios.get('/api/v1/project/'+props.project['id']+'/categories', {})
        .then(function (response) {
            categories_list.value = response.data.data
            //c.process = false
        })
        .catch(function (error) {
            //c.process = false
        });
}

function loadKeywords() {
    axios.get('/api/v1/project-keywords/'+props.project['id'], {params: {'categories': selected_categories_list.value}})
        .then(function (response) {
            keywords.value = response.data.data
            //c.process = false
        })
        .catch(function (error) {
            //c.process = false
        });
}

function removeKeyword(id) {
    axios.delete('/api/v1/project-keywords/'+id+'/destroy', {})
        .then(function (response) {
            // keywords.value = response.data.data
            //c.process = false
            loadKeywords()
            loadCategories()
        })
        .catch(function (error) {
            //c.process = false
            loadKeywords()
            loadCategories()
        });


}

onMounted(() => {
    loadCategories()
})


const show_modal_keyword = ref(false)
const modal_keyword_category = ref(null)
const modal_keyword_list = ref(null)

function add_keywords() {
    // do
    if (modal_keyword_list.value == null || modal_keyword_list.value.length < 1 || modal_keyword_category.value == null) {
        return
    }

    axios.post('/api/v1/project-keywords/'+props.project['id']+'/create-keywords', { keywords: modal_keyword_list.value, category_id: modal_keyword_category.value })
        .then(function (response) {
            modal_keyword_category.value = null
            modal_keyword_list.value = null
            show_modal_keyword.value = false
            loadKeywords()
            loadCategories()
        })
        .catch(function (error) {
            loadKeywords()
            loadCategories()
        });
}



const show_modal_group = ref(false)
const modal_group_category = ref(null)
const modal_group_name = ref(null)

function add_group() {
    // do
    if (modal_group_name.value == null || modal_group_name.value.length < 1) {
        return
    }

    axios.post('/api/v1/project-keywords/'+props.project['id']+'/create-category', { name: modal_group_name.value, category_id: modal_group_category.value })
        .then(function (response) {
            modal_group_category.value = null
            modal_group_name.value = null
            show_modal_group.value = false
            loadKeywords()
            loadCategories()
        })
        .catch(function (error) {
            loadKeywords()
            loadCategories()
        });
}

</script>

<template>
    <Head title="Поисковые запросы" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Поисковые запросы</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item"><a :href="'/projects/' + project['id']">{{ project['name']}}</a></li>
                    <li class="breadcrumb-item">Поисковые запросы</li>
                </ol>
            </div>
            <div class="col-sm-6 text-right">
                <button @click="show_modal_keyword = true" class="btn btn-primary m-r-15" type="button">Добавить ключи</button>
                <button @click="show_modal_group = true" class="btn btn-secondary" type="button">Добавить раздел</button>
            </div>
        </div>
    </div>

    <div v-if="$page.props.flash.message" class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div class="row">
        <div class="col-sm-9">
            <div class="card mb-0">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ключ</th>
                            <th>Путь</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="keywords.length === 0">
                            <td colspan="4" class="text-center"><p>По вашему запросу, нет колючевых слов</p></td>
                        </tr>
                        <tr v-for="keyword in keywords">
                            <td><p>{{ keyword.id }}</p></td>
                            <td><p>{{ keyword.text }}</p></td>
                            <td><p>{{ keyword.path.join(' > ') }}</p></td>
                            <td class="text-right">
<!--                                <span class="cursor-pointer d-inline-block m-r-10">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>-->
<!--                                </span>-->

                                <span @click="removeKeyword(keyword['id'])" class="cursor-pointer d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <n-tree
                        checkable
                        :data="categories_list"
                        @update:checked-keys="treeCheckedKeys"
                        :node-props="treeProps"
                    />
                </div>
            </div>
        </div>
    </div>

    <n-modal v-model:show="show_modal_group" transform-origin="center">
        <n-card
            style="width: 600px"
            title="Добавить новую группу"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
        >
            <n-tree-select
                clearable
                :options="categories_list"
                v-model:value="modal_group_category"
                placeholder="Выберите категорию"
            >
            </n-tree-select>
            <br>
            <n-input v-model:value="modal_group_name" type="text" placeholder="Название" />
            <br><br>
            <n-button @click="add_group">Добавить</n-button>
        </n-card>
    </n-modal>

    <n-modal v-model:show="show_modal_keyword" transform-origin="center">
        <n-card
            style="width: 600px"
            title="Добавить ключевые слова"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
        >
            <n-tree-select
                :options="categories_list"
                v-model:value="modal_keyword_category"
                placeholder="Выберите категорию"
            >
            </n-tree-select>
            <br>
            <n-input v-model:value="modal_keyword_list" type="textarea" placeholder="Ключевые слова (по одному в строку)" />
            <br><br>
            <n-button @click="add_keywords">Добавить</n-button>
        </n-card>
    </n-modal>
</template>
