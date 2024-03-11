<div class="sidebar-user text-center">
    <a class="setting-primary" href="{{ route('profile.edit') }}"><i data-feather="settings"></i></a>

    @if($user->avatar)
        <img class="img-90 rounded-circle" src="{{ $user->avatar }}" alt="">
    @else
        <img class="img-90 rounded-circle" src="{{ Vite::asset('resources/images/dashboard/1.png') }}" alt="">
    @endif

    <div class="badge-bottom"><span class="badge badge-primary">{{ $user->role->name }}</span></div>
    <a href="{{ route('profile.edit') }}"><h6 class="mt-3 f-14 f-w-600">{{ $user->name }}</h6></a>
    <p class="mb-0 font-roboto">{{ $user->email }}</p>

    <ul>
        <li>
            <span>{{ $userProjects->count() }}</span>
            <p>Проекты</p>
        </li>
        <li>
            <span><span class="counter">{{ $userProjects->sum('keywords_count') }}</span></span>
            <p>Запросы</p>
        </li>
        <li><span><span class="counter">0</span>$</span>
            <p>Баланс</p>
        </li>
    </ul>
</div>
