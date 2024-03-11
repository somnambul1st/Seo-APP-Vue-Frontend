@extends('layouts.app')

@section('title')
    Создание нового проекта
@endsection

@section('page-title')
    <h3>Создание нового проекта</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Дашборд</a></li>
        <li class="breadcrumb-item">Создать новый проект</li>
    </ol>
@endsection

{{--https://habr.com/ru/post/564844/--}}

@section('page-options')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data" class="form theme-form">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label>Название</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Новый проект" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Домен</label>
                                    <input class="form-control @error('domain') is-invalid @enderror" type="text" name="domain" placeholder="example.ru" value="{{ old('domain') }}">
                                    @error('domain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Регион Yandex</label>
                                    <select class="form-select @error('yandex_region_id') is-invalid @enderror" name="yandex_region_id">
                                        @foreach(\App\Services\YandexRegionService::list() as $regionId => $regionName)
                                            <option value="{{ $regionId }}" @if($regionId == old('yandex_region_id')) selected @endif>{{ $regionName }}</option>
                                        @endforeach
                                    </select>
                                    @error('yandex_region_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                {{-- владелец --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="d-block" for="chk-ani">
                                        <input class="checkbox_animated" id="ay" type="checkbox" name="auto_yandex" {{ old('auto_yandex') ? 'checked' : '' }}> Снимать позиции в Yandex каждый день
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 col-12">
                                <div class="mb-3">
                                    <label>Файл для импорта ключевых запросов (.kc4)</label>
                                    <input class="form-control @error('import_file') is-invalid @enderror" type="file" name="import_file" value="{{ old('import_file') }}">
                                    @error('import_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <div class="text-start">
                                    <button class="btn btn-primary me-3" type="submit">Создать новый проект</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
