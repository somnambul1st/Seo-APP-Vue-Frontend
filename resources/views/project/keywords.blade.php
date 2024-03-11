@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('page-title')
    <h3>{{ $project->name }}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Все проекты</a></li>
        <li class="breadcrumb-item">{{ $project->name }}</li>
        <li class="breadcrumb-item">Поисковые запросы</li>
    </ol>
@endsection

@section('page-options')
@endsection

@section('content')
    <div class="row">

    </div>
@endsection
