<template>
    <Head title="Список пользователей" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Список пользователей</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><Link href="/">Все проекты</Link></li>
                    <li class="breadcrumb-item">Пользователи</li>
                </ol>
            </div>
            <div class="col-sm-6 text-right">
                <Link href="/users/create" class="btn btn-primary" type="button">Добавить пользователя</Link>
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
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Проекты</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users">
                                <td>
                                    <p>
                                        <img :src="user['avatar']" style="border-radius: 50%" width="50" height="50" class="m-r-5" alt="">
                                        {{ user['name'] }}
                                    </p>
                                </td>
                                <td><p>{{ user['email'] }}</p></td>
                                <td><p>{{ user['role'] }}</p></td>
                                <td><p>{{ user['projects'].join(', ') }}</p></td>
                                <td class="text-right">
                                    <Link :href="'/users/' + user['id'] + '/edit'" class="btn btn-primary" type="button">Редактировать</Link>
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

defineProps({ users: Object })
</script>
