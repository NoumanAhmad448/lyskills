@if (config('setting.en_reg_form'))
    <div class="p-6 bg-gray-100 flex items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <section class="mt-20">
                <h1 class="pb-5 font-semibold text-xl text-gray-600">{{ __('messages.reg_form_title') }}</h1>
                @include("register_user")
            </section>
        </div>
    </div>
@endif
