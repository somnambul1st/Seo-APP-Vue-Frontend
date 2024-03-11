@extends('layouts.guest')

@section('title')
    Авторизация
@endsection

@section('content')
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <form class="theme-form login-form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <img src="{{ Vite::asset('resources/images/logo/logo.png') }}" alt="">
                            </div>

                            <h4>Авторизация</h4>
                            <h6>Добро пожаловать, войдите в свой аккаунт.</h6>

                            <div class="form-group">
                                <label>Email адрес</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" type="text" placeholder="Ваш email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Пароль</label>
                                <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Ваш пароль">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox" name="remember">
                                    <label for="checkbox1">Сохранить сессию</label>
                                </div>

                                <a class="link" href="#">Забыли пароль?</a>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Войти</button>
                            </div>

                            <p>Все еще не зарегистрированы? <a class="ms-2" href="#">Пройти регистрацию</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
