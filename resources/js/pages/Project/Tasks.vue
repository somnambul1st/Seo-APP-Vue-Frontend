<template>
    <Head title="Задачи" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Задачи</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item"><a :href="'/projects/' + project.id">{{ project.name }}</a></li>
                    <li class="breadcrumb-item">Задачи</li>
                </ol>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>

    <div v-if="$page.props.flash.message" class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div v-if="$page.props.flash.error" class="mb-4 alert alert-danger dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.error }}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                            <tr>
                                <th>Задача</th>
                                <th>Дата создания</th>
                                <th>Выполнена</th>
                                <th>Отменена</th>
                                <th>Прогрес</th>
                                <th>Затраченое время</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="tasks.length === 0">
                                <td colspan="7" class="text-center"><p class="mt-3">Нет активных задач</p></td>
                            </tr>
                            <tr v-for="task in tasks">
                                <td><p>{{ task.description }}</p></td>
                                <td><p>{{ task.created_at }}</p></td>
                                <td><p>{{ task.is_finished ? 'Да' : 'Нет' }}</p></td>
                                <td><p>{{ task.is_canceled ? 'Да' : 'Нет' }}</p></td>
                                <td><p>{{ task.progress }} %</p></td>
                                <td><p>{{ task.time_work }}</p></td>
                                <td><Link method="post" :href="'/projects/' + project.id + '/tasks/' + task.id + '/destroy'">Удалить</Link></td>
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
const props = defineProps({ project: Object, tasks: Array })
</script>
