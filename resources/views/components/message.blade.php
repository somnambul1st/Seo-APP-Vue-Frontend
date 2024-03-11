@if (session()->has('message'))
    <div class="mb-4 alert alert-light dark alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
