@php
    use App\Models\Categories;
@endphp
<div class="dropdown">
    <div class="ml-4 cursor_pointer show-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
    </div>
    <div class="dropdown-menu categories_menu">
        @php
            $cs = Categories::all();
        @endphp
        @if ($cs->count())
            @foreach ($cs as $c)
                @if ($c->value && $c->name)
                    <a class="dropdown-item" href="{{ route('user-categories', ['category' => $c->value]) }}">
                        {{ $c->name }}
                    </a>
                @endif
            @endforeach
        @endif
    </div>
</div>
