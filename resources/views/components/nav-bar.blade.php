<div class="nav-right col pull-right right-menu p-0">
    <ul class="nav-menus">
        <li><a class="text-dark" href="#"><i data-feather="maximize"></i></a></li>
        <li class="onhover-dropdown p-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-primary-light" type="submit"><i data-feather="log-out"></i>Выйти из аккаунта</button>
            </form>
        </li>
    </ul>
</div>
<div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
