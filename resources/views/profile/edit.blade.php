@extends('layouts.app')

@section('title')
    Профиль пользователя
@endsection

@section('page-title')
    <h3>Профиль пользователя</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Дашборд</a></li>
        <li class="breadcrumb-item">{{ $user->name }}</li>
    </ol>
@endsection

@section('page-options')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @include('components.message')

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form theme-form">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="media">
                                    @if($user->avatar)
                                        <img class="img-70 rounded-circle" src="{{ $user->avatar }}" alt="">
                                    @else
                                        <img class="img-70 rounded-circle" src="{{ Vite::asset('resources/images/dashboard/1.png') }}" alt="">
                                    @endif

                                    <div class="media-body m-l-20">
                                        <label>Загрузить новый аватар:</label>
                                        <input class="form-control @error('picture') is-invalid @enderror" type="file" name="picture">
                                        @error('picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Имя:</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Ваше имя" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Email:</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Ваш email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Новый пароль:</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Новый пароль" value="">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="text-start">
                                    <button class="btn btn-primary me-3" type="submit">Обновить профиль</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
