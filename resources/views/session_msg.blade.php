@if (session('status'))
    <div class="alert alert-success text-center">
        {{ session('status') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif