@if(isset($project))
    <ul class="nav-menu custom-scrollbar">
        <li></li>
        <li class="dropdown">
            <a class="nav-link menu-title link-nav @if(request()->routeIs('projects.show')) active @endif" href="{{ route('projects.show', ['project' => $project]) }}">
                <i data-feather="bar-chart"></i> <span>Проверка позиций</span>
            </a>
        </li>
        <li class="dropdown mt-2">
            <a class="nav-link menu-title link-nav @if(request()->routeIs('projects.keywords')) active @endif" href="{{ route('projects.keywords', ['project' => $project]) }}">
                <i data-feather="list"></i> <span>Поисковые запросы</span>
            </a>
        </li>
        <li class="dropdown mt-2">
            <a class="nav-link menu-title link-nav @if(request()->routeIs('projects.tasks')) active @endif" href="{{ route('projects.tasks', ['project' => $project]) }}">
                <i data-feather="git-pull-request"></i> <span>Задачи</span>
            </a>
        </li>
        <li class="dropdown mt-2">
            <a class="nav-link menu-title link-nav @if(request()->routeIs('projects.edit')) active @endif" href="{{ route('projects.edit', ['project' => $project]) }}">
                <i data-feather="sliders"></i> <span>Настройки</span>
            </a>
        </li>
    </ul>
@else
@endif




