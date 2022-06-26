@if (session('status'))
    <div class="alert alert-warning">
        {{ session('msg') }}
    </div>
@endif
