@if (config('setting.all_faqs'))
    @if (isset($faq) && $faq)
        <div class="container-fluid my-3">
            <div class="row">
                <div class="col-md-12">
                    @include('sn.load_container')
                    <div class="d-flex justify-content-end content-main">
                        <a href="{{ route('public_faq') }}"
                            class="btn btn-lg btn-website">{{ __('homepage.faq.all') }}</a>
                    </div>
                </div>
                <div class="col-md-8 offset-md-2">
                    @include('sn.load_container')
                    <section class="content-main">
                        <h2 class="my-2">{{ __('homepage.faq.recent') }}</h2>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <img src="{{ config('setting.s3Url') . $faq->upload_img }}"
                                    alt="{{ $faq->f_name ?? '' }}" class="img-fluid" />
                            </div>
                        </div>
                        <h3 class="text-center mt-2 text-uppercase">
                            {{ $faq->title }}
                        </h3>
                        <div class="mt-2">
                            {!! reduceWithStripping($faq->message, 300) !!}
                        </div>
                        <a href="{{ route('public_faqs', ['slug' => $faq->slug]) }}"
                            class="btn btn-website my-2 float-right">
                            {{ __('homepage.faq.read_more') }}
                        </a>
                    </section>
                </div>
            </div>
        </div>
    @endif
@endif
