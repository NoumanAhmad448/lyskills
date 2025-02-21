@extends('layouts.guest')
@section('content')
    <div class="container" style="margin-top: 4rem !important">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('instructor.auth.register_title') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('instructor.register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.name') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Enter your full name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.email') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Enter your email address">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expertise" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.expertise') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="expertise" type="text"
                                        class="form-control @error('expertise') is-invalid @enderror" name="expertise"
                                        value="{{ old('expertise') }}" required
                                        placeholder="e.g. Web Development, Data Science">

                                    @error('expertise')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="teaching_experience" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.teaching_experience') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="teaching_experience" type="number"
                                        class="form-control @error('teaching_experience') is-invalid @enderror"
                                        name="teaching_experience" value="{{ old('teaching_experience') }}" required
                                        min="0"
                                        placeholder="Years of teaching experience">

                                    @error('teaching_experience')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="qualification" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.qualification') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="qualification" type="text"
                                        class="form-control @error('qualification') is-invalid @enderror"
                                        name="qualification" value="{{ old('qualification') }}" required
                                        placeholder="e.g. Masters in Computer Science">

                                    @error('qualification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.password') }}
                                </label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" 
                                            name="password" required autocomplete="new-password"
                                            placeholder="password min 8 digits">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info cursor-pointer text-white" id="show_pass">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                    {{ __('instructor.fields.password_confirmation') }}
                                </label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" 
                                            class="form-control" name="password_confirmation" 
                                            required autocomplete="new-password"
                                            placeholder="confirm password">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info cursor-pointer text-white" id="show_confirm_pass">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <div class="alert alert-danger mt-2">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                    <a href="{{ route('instructor.login') }}" class="btn btn-link">
                                        {{ __('instructor.auth.Login_link') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('js/password-toggle.js') }}"></script>
@endsection

