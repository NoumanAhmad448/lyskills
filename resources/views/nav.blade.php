<nav class="p-2 d-md-flex justify-content-md-between mb-2 mb-md-0">
    <div class="container-fluid">
        <div class="row">
            @if (config('setting.category_menu'))
                <div class="col-md-2">
                    <div class="d-md-flex align-items-md-center">
                        @if (config('setting.show_site_log'))
                            <a href="{{ route('index') }}" class=""> <img
                                    src="{{ asset(config('setting.img_logo_path')) }}" alt="Lyskills" width="80"
                                    class="img-fluid" /></a>
                        @endif
                        @includeWhen(true, 'categories')
                    </div>
                </div>
            @endif
            @include('seach')
            <div class="col-md-2">
                @include('right')

                <div class="col-md-2">

                    <div class="d-md-flex align-items-md-center justify-content-md-end">
                        @include('login_op')
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
