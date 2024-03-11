<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3'
import { ref, onMounted } from "vue";
import { NUpload, NButton, NSelect, NRadioGroup, NRadio, NSpace, NTimePicker, NCheckboxGroup, NCheckbox, NUploadDragger, NP, NText } from 'naive-ui'


const props = defineProps({ user: Object, project: Object })

const upload_process = ref(false)

const form = useForm({
    import_file: null,
})

const uploadPicture = ({file, event}) => {
    form.import_file = (event?.target).response
    upload_process.value = false
};

const errorPicture = ({file, event}) => {
    upload_process.value = false
    form.import_file = null
};

const removePicture = ({file}) => {
    form.import_file = null
    upload_process.value = false
};

const startUpload = ({file}) => {
    upload_process.value = true
};

function upload() {
    if (upload_process.value) {
        return
    }

    form.post('/projects/' + props.project['id'] + '/import-store', {
        preserveScroll: true,
        //onSuccess: () => form.reset('password'),
        //onError: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="Импорт запросов" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Импорт запросов</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item"><a :href="'/projects/' + project['id']">{{ project['name']}}</a></li>
                    <li class="breadcrumb-item">Импорт запросов</li>
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
        <div class="col">
            <div class="card mb-0">
                <div class="card-body">
                    <div>
                        <label>Файл для импорта ключевых запросов (.kc4, .csv): </label>
                        <div class="media">
                            <div class="media-body">
                                <n-upload
                                    directory-dnd
                                    action="/upload"
                                    @finish="uploadPicture"
                                    @remove="removePicture"
                                    @beforeUpload="startUpload"
                                    @error="errorPicture"
                                    accept=".kc4,.csv"
                                    max="1"
                                >
                                    <n-upload-dragger>
                                        <n-text style="font-size: 16px">
                                            Нажмите или перетащите файл в эту область, чтобы загрузить
                                        </n-text>
                                        <n-p depth="3" style="margin: 8px 0 0 0">
                                            Строго запретить загружать конфиденциальную информацию. Например,
                                            PIN-код вашей банковской карты или срок действия кредитной карты.
                                        </n-p>
                                    </n-upload-dragger>
                                </n-upload>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div>
                        Тут написать какой формат подходит, ссылку на пример .csv и т.д
                    </div>

                    <br><br>
                    <button class="btn btn-primary me-3" @click="upload" :disabled="upload_process" type="submit">Загрузить ключевые слова из этого файла</button>
                </div>
            </div>
        </div>
    </div>
</template>
