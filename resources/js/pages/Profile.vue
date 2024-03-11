<template>
    <Head title="Профиль пользователя" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Профиль пользователя</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item">Профиль пользователя</li>
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
                                <div class="media">
                                    <img class="img-90 height-90 rounded-circle" v-if="form.picture != null" :src="'/img/' + form.picture + '?w=100&h=100&crop=fit'" alt="">
                                    <img class="img-90 height-90 rounded-circle" v-else src="../../images/dashboard/1.png" alt="">

                                    <div class="media-body m-l-20">
                                        <n-upload
                                            action="/upload"
                                            @finish="uploadPicture"
                                            @remove="removePicture"
                                            @beforeUpload="startUpload"
                                            @error="errorPicture"
                                            accept=".png,.jpg,.bmp"
                                            max="1"
                                        >
                                            <n-button>Загрузить файл</n-button>
                                        </n-upload>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <v-input label="Имя" v-model="form.name" placeholder="Ваше имя" :error="form.errors.name"/>
                            </div>
                            <div class="col-sm-4">
                                <v-input label="Email" v-model="form.email" placeholder="Ваш email" :error="form.errors.email"/>
                            </div>
                            <div class="col-sm-4">
                                <v-input label="Новый пароль" v-model="form.password" placeholder="Новый пароль" :error="form.errors.password"/>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="text-start">
                                    <button class="btn btn-primary me-3" :disabled="upload_process" type="submit">Обновить профиль</button>
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
import { router } from '@inertiajs/vue3'
import VInput from "../components/VInput.vue"
import { NUpload, NButton } from 'naive-ui'
import { ref } from 'vue'

const props = defineProps({ profile: Object })

const upload_process = ref(false)

const form = useForm({
    name: props.profile['name'],
    email: props.profile['email'],
    picture: props.profile['picture'],
    password: null,
})

function submit() {
    if (upload_process.value) {
        return
    }

    form.put('/profile', {
        preserveScroll: true,
        //onSuccess: () => form.reset('password'),
        onError: () => form.reset('password'),
    })
}

const uploadPicture = ({file, event}) => {
    form.picture = (event?.target).response
    upload_process.value = false
};

const errorPicture = ({file, event}) => {
    upload_process.value = false
    form.picture = null
};

const removePicture = ({file}) => {
    form.picture = null
    upload_process.value = false
};

const startUpload = ({file}) => {
    upload_process.value = true
};
</script>
