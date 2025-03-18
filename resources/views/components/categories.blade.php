@if (config('setting.all_categories'))
    @if (isset($cs) && $cs->count())
        <div class="container-fluid my-4">
            <h2>{{ __('homepage.categories.title') }}</h2>
            <div class="row my-2">
                @foreach ($cs as $c)
                    <div class="col-md-3 mt-3">
                        @include('sn.load_btn')
                        <div class="content-main">

                            <div class="card text-center">
                                <a href="{{ route('user-categories', ['category' => $c->value]) }}"
                                    class="p-3 btn-website font-bold" style="font-weight: bold">
                                    {{ $c->name ?? '' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endif
