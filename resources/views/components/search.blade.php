<ul>
    <li>
        <div class="dropdown select-main-project">
            <button class="btn btn-light" type="button" data-bs-toggle="dropdown">
                <i data-feather="box"></i>
                @if(isset($project))
                    {{ $project->name }}
                @else
                    Выберите проект
                @endif
            </button>
            <ul class="dropdown-menu">
                @foreach($userProjects as $userProject)
                    <li class="d-block">
                        <a class="dropdown-item" href="{{ route('projects.show', ['project' => $userProject]) }}">{{ $userProject->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
{{--    <li>--}}
{{--        <a href="{{ route('projects.create') }}" class="btn btn-secondary">Создать новый проект</a>--}}
{{--    </li>--}}
</ul>
