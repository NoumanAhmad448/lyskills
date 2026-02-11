@if (config('setting.homepage_image'))
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                @include('sn.load_img')
                <section style="position: relative" class="content-main">
                    <img src="{{ $settings && $settings->homepage_photo ? config('setting.s3Url') . $settings->homepage_photo : asset('img/student.jpg') }}"
                        alt="{{ __('homepage.alt_text.student') }}" class="img-fluid mx-auto d-block" id="student_img"
                        style="box-shadow: 0px 10px 10px 3px #605f5b;" />
                    <a href="{{ route('register') }}" class="btn btn-outline-website d-none"
                        style="position: absolute; top: 0;left: 0;">
                        {{ __('homepage.buttons.instructor') }}
                    </a>
                </section>
            </div>
        </div>
    </div>
@endif
