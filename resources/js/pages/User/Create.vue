<template>
    <Head title="Создание нового пользователя" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Создание нового пользователя</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item">Создание нового пользователя</li>
                </ol>
            </div>
            <div class="col-sm-6"></div>
        </div>
    </div>

    <div v-if="$page.props.flash.message" class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ $page.props.flash.message }}
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="submit" class="form theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <v-input label="Имя" v-model="form.name" placeholder="Имя" :error="form.errors.name"/>
                            </div>
                            <div class="col-sm-4">
                                <v-input label="Email" v-model="form.email" placeholder="test@example.ru" :error="form.errors.email"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Роль</label>
                                    <n-select
                                        v-model:value="form.role"
                                        filterable
                                        placeholder="Выберите роль"
                                        :options="[{ 'label': 'Админ', 'value': 'admin' }, { 'label': 'Клиент', 'value': 'client' }]"
                                    />
                                    <div v-if="form.errors.role != null" class="invalid-feedback" style="display: block">{{ form.errors.role }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <v-input label="Новый пароль" v-model="form.password" placeholder="Новый пароль" :error="form.errors.password"/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="text-start">
                                    <button class="btn btn-primary me-3" type="submit">Создать пользователя</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { NUpload, NButton, NSelect, NRadioGroup, NRadio, NSpace, NTimePicker, NCheckboxGroup, NCheckbox } from 'naive-ui'
import { ref } from 'vue'
import VInput from "../../components/VInput.vue";

const props = defineProps({ })

const form = useForm({
    name: null,
    email: null,
    password: null,
    role: null,
})

function submit() {
    form.post('/users', {
        preserveScroll: true,
        //onSuccess: () => form.reset('password'),
        //onError: () => form.reset('password'),
    })
}
</script>
