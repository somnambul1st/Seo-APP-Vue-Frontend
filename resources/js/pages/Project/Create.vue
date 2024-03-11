<template>
    <Head title="Создание нового проекта" />

    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3>Создание нового проекта</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Все проекты</a></li>
                    <li class="breadcrumb-item">Создание нового проекта</li>
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
                            <div class="col">
                                <v-input label="Название" v-model="form.name" placeholder="Новый проект" :error="form.errors.name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <v-input label="Домен" v-model="form.domain" placeholder="example.ru" :error="form.errors.domain"/>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Регион Yandex</label>
                                    <n-select
                                        v-model:value="form.yandex_region_id"
                                        filterable
                                        placeholder="Выберите регион в Yandex"
                                        :options="regions"
                                    />
                                    <div v-if="form.errors.yandex_region_id != null" class="invalid-feedback">{{ form.errors.yandex_region_id }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
<!-- -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Автоматический сбор позиций:</label>

                                <div>
                                    <n-radio-group v-model:value="form.parse_period" name="parse_period">
                                        <n-space>
                                            <n-radio
                                                key="none"
                                                value="none"
                                                label="Не использовать"
                                            />
                                            <n-radio
                                                key="every_day"
                                                value="every_day"
                                                label="Каждый день"
                                            />
                                            <n-radio
                                                key="week_day"
                                                value="week_day"
                                                label="По дням недели"
                                            />
                                            <n-radio
                                                key="mouth_day"
                                                value="mouth_day"
                                                label="По дням месяца"
                                            />
                                        </n-space>
                                    </n-radio-group>
                                </div>

                                <div>
                                    <div class="row mt-3" v-if="form.parse_period != 'none'">
                                        <div class="col-sm-2">
                                            <label>Запускать во время:</label>
                                            <n-time-picker
                                                placeholder="Выберите время запуска"
                                                v-model:value="form.parse_time"
                                                :hours="[8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]"
                                                :minutes="[0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55]"
                                                :seconds="[0]"
                                            />
                                        </div>
                                        <div class="col" style="padding-top:30px" v-if="form.parse_period == 'week_day'">
                                            <n-checkbox-group v-model:value="form.parse_week_days">
                                                <n-space item-style="display: flex;" align="center">
                                                    <n-checkbox value="1" label="ПН" />
                                                    <n-checkbox value="2" label="ВТ" />
                                                    <n-checkbox value="3" label="СР" />
                                                    <n-checkbox value="4" label="ЧТ" />
                                                    <n-checkbox value="5" label="ПТ" />
                                                    <n-checkbox value="6" label="СБ" />
                                                    <n-checkbox value="7" label="ВС" />
                                                </n-space>
                                            </n-checkbox-group>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label>Файл для импорта ключевых запросов (.kc4, .csv)</label>
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
                                        <br>
                                        <div>
                                            Тут написать какой формат подходит, ссылку на пример .csv и т.д
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="text-start">
                                    <button class="btn btn-primary me-3" :disabled="upload_process" type="submit">Создать новый проект</button>
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
import { NUpload, NButton, NSelect, NRadioGroup, NRadio, NSpace, NTimePicker, NCheckboxGroup, NCheckbox, NUploadDragger, NP, NText } from 'naive-ui'
import { ref } from 'vue'
import VInput from "../../components/VInput.vue";

const props = defineProps({ regions: Array })

const upload_process = ref(false)

const form = useForm({
    name: null,
    domain: null,
    yandex_region_id: 225,
    parse_period: 'none',
    parse_time: new Date("2017-01-26 09:00:00"),
    parse_week_days: [],
    import_file: null,
})

function submit() {
    if (upload_process.value) {
        return
    }

    form.post('/projects', {
        preserveScroll: true,
        //onSuccess: () => form.reset('password'),
        //onError: () => form.reset('password'),
    })
}

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
</script>
