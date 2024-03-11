@extends('layouts.app')

@section('title')
    Проекты
@endsection

@section('page-title')
    <h3>Все проекты</h3>
@endsection

@section('page-options')
    <a href="{{ route('projects.create') }}" class="btn btn-secondary">Создать новый проект</a>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            @include('components.message')

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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $item)
                                    <tr>
                                        <td>
                                            <p>{{ $item->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $item->domain }}</p>
                                        </td>
                                        <td>
                                            <p>{{ \App\Services\YandexRegionService::list()[$item->yandex_region_id] ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $item->keywords()->count() }}</p>
                                        </td>
                                        <td class="" style="text-align: right">
                                            <a href="{{ route('projects.show', ['project' => $item]) }}" class="btn btn-primary" type="button">Перейти в проект</a>
                                            <a href="{{ route('projects.yandex', ['project' => $item]) }}" class="btn btn-secondary" type="button">Съем позиций</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
