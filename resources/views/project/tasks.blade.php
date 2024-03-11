@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('page-title')
    <h3>{{ $project->name }}</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Все проекты</a></li>
        <li class="breadcrumb-item">{{ $project->name }}</li>
        <li class="breadcrumb-item">Задачи</li>
    </ol>
@endsection

@section('page-options')
@endsection

@section('content')
    <div class="row">
        <div class="col">
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
                            @foreach($tasks as $task)
                                <tr>
                                    <td>
                                        <p>{{ $task->description }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $task->created_at }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $task->batch->finished() ? 'Да' : 'Нет' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $task->batch->canceled() ? 'Да' : 'Нет' }}</p>
                                    </td>
                                    <td>
                                        {{ $task->batch->progress() }} %
                                    </td>
                                    <td>
                                        {{ $task->batch->finishedAt ? $task->batch->finishedAt->longAbsoluteDiffForHumans($task->batch->createdAt) : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('task-destroy', ['project' => $task->project, 'task' => $task]) }}">Удалить</a>
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
