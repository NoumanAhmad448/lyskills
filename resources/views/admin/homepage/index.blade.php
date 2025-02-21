@extends('admin.admin_main')
@section('content')
    <div class="card">
        <div class="card-header bg-website">
            <h3 class="text-white">{{ __('homepage.titles.main') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <h4>{{ __('homepage.titles.photo_section') }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" name="homepage_photo" class="form-control" accept="image/*">
                            <small class="text-muted">{{ __('homepage.help.photo_size') }}</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>{{ __('homepage.titles.current_photo') }}</h5>
                        @if($settings && $settings->homepage_photo)
                            <img src="{{ config('setting.s3Url').$settings->homepage_photo }}" 
                                 class="img-fluid" 
                                 style="max-height: 300px; box-shadow: 0px 10px 10px 3px #605f5b;" 
                                 alt="{{ __('homepage.alt_text.homepage_photo') }}"
                                 id="student_img"/>
                            <div class="mt-2">
                                <small class="text-muted">
                                    {{ __('homepage.labels.original_filename') }}: {{ $settings->homepage_photo_name }}<br>
                                    {{ __('homepage.labels.last_updated') }}: {{ $settings->homepage_photo_updated_at }}
                                </small>
                            </div>
                        @else
                            <img src="{{ asset('img/student.jpg') }}" 
                                 class="img-fluid" 
                                 style="max-height: 300px; box-shadow: 0px 10px 10px 3px #605f5b;" 
                                 alt="{{ __('homepage.alt_text.student') }}"
                                 id="student_img"/>
                        @endif
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('homepage.buttons.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection 