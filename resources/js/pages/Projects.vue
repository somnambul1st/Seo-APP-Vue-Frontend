<template>
    <Head title="Все проекты" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Дашборд</h3>
            </div>
            <div class="col-sm-6 text-right">
                <Link href="/projects/create" class="btn btn-primary" type="button">Создать новый проект</Link>
            </div>
        </div>
    </div>

    <div v-if="$page.props.flash.message" class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div v-if="$page.props.flash.error" class="mb-4 alert alert-danger dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.error }}
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Домен</th>
                                <th>Регион Yandex</th>
                                <th>Кол-во запросов</th>
                                <th>Кол-во групп</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="project in projects">
                                <td><p>{{ project['name'] }}</p></td>
                                <td><p>{{ project['domain'] }}</p></td>
                                <td><p>{{ project['yandex_region_name'] }}</p></td>
                                <td><p>{{ project['keywords_count'] }}</p></td>
                                <td><p>{{ project['categories_count'] }}</p></td>
                                <td class="text-right">
                                    <Link :href="'/projects/' + project['id']" class="btn btn-primary" type="button">Перейти в проект</Link>
                                    <Link v-if="user.role === 'Admin' || user.id == project.owner_id" :href="'/projects/' + project['id'] + '/tasks/parse-yandex'" method="post" as="button" class="btn btn-secondary m-l-10" type="button">Съем позиций Yandex</Link>
                                    <Link v-if="user.role === 'Admin' || user.id == project.owner_id" :href="'/projects/' + project['id']" method="delete" class="btn btn-danger m-l-10" type="button">Удалить</Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({ projects: Object, user: Object })
</script>
