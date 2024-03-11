<template>
    <Head title="Проверка позиций" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Проверка позиций</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item"><a :href="'/projects/' + project.id">{{ project.name }}</a></li>
                    <li class="breadcrumb-item">Проверка позиций</li>
                </ol>
            </div>
            <div class="col-sm-6">
                <div class="bookmark">
                    <ul>
                        <li v-if="user.role === 'Admin' || user.id == project.owner_id">
                            <Link class="d-block" method="post" :href="'/projects/' + project.id + '/tasks/parse-yandex'" data-toggle="tooltip" data-placement="bottom" title="Запустить проверку позиций">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M1 4v6h6m16 10v-6h-6"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/></g></svg>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div v-if="$page.props.flash.message" class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div v-if="$page.props.flash.error" class="mb-4 alert alert-danger dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.error }}
    </div>

    <div v-if="has_active_parse_task" class="mb-4 alert alert-dark dark alert-dismissible fade show" role="alert">
        Идет процесс съема позиций в поисковой системе Yandex!
    </div>

    <div v-if="has_active_import_task" class="mb-4 alert alert-dark dark alert-dismissible fade show" role="alert">
        Идет процесс импорта ключевых слов!
    </div>

    <project-metrics :project-id="project['id']" :min-day="min" :max-day="max"></project-metrics>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import ProjectMetrics from "../../components/ProjectMetrics.vue";

const props = defineProps({ user: Object, project: Object, min: Number, max: Number, has_active_parse_task: Boolean, has_active_import_task: Boolean })
</script>
