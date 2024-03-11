@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('page-title')
    <h3>{{ $project->name }}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Все проекты</a></li>
        <li class="breadcrumb-item">{{ $project->name }}</li>
        <li class="breadcrumb-item">Проверка позиций</li>
    </ol>
@endsection

@section('page-options')
    <div class="bookmark">
        <ul>
            <li>
                <a class="d-block" href="{{ route('projects.yandex', ['project' => $project]) }}" data-toggle="tooltip" data-placement="bottom" title="Запустить проверку позиций">
                    <i data-feather="refresh-ccw"></i>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    @if($yandexPos)
    <div class="mb-4 alert alert-dark dark alert-dismissible fade show" role="alert">
        Идет процесс съема позиций в поисковой системе Yandex!
    </div>
    @endif

    @include('components.message')

    <div id="app">
        <project-metrics project-id="{{ $project->id }}" min-day="{{ $min_day }}" max-day="{{ $max_day }}"></project-metrics>
    </div>
@endsection
