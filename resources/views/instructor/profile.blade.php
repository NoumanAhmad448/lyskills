{{-- <x-app-layout>     --}}
    @extends('layouts.dashboard_header')

    @section('page-css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @endsection
    @section('header')
        <h1> Instructor Profile  </h1>
    @endsection

    @section('content')
        <div class="container mb-5">
            <div class="row">
                <div class="col-md-10">
                    @include('session_msg')
                    <form method="POST" action="{{route('i-profile-post')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="name"> Name </label>
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                   aria-describedby="user name" placeholder="Name" value="@if($user){{$user->name}}@else{{old('name')}}@endif" />
                                  @error('name')
                                    <div class="show_message show_message-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="headline"> Headline </label>
                                  <input type="text" class="form-control @error('headline') is-invalid @enderror" id="headline" name="headline"
                                   aria-describedby="user headline" placeholder="Professional title" value="@if($profile){{$profile->headline}}@else{{old('headline')}}@endif" />
                                  @error('headline')
                                    <div class="show_message show_message-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label for="bio"> Bio </label>
                                  <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="10"
                                   aria-describedby="user bio" placeholder="Professional title">@if($profile){{$profile->bio}}@else{{old('bio')}}@endif</textarea>
                                  @error('bio')
                                    <div class="show_message show_message-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="website"> Website </label>
                                  <input type="text" class="form-control @error('website') is-invalid @enderror" id="website" name="website" 
                                   aria-describedby="user website" placeholder="website URL" value="@if($profile){{$profile->website}}@else{{old('website')}}@endif" />
                                    @error('website')
                                      <div class="show_message show_message-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="facebook"> Facebook URL </label>
                                  <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" 
                                   aria-describedby="user facebook" placeholder="facebook URL" value="@if($profile){{$profile->facebook}}@else{{old('facebook')}}@endif" />
                                    @error('facebook')
                                      <div class="show_message show_message-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="twitter"> Twitter URL </label>
                                  <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" 
                                   aria-describedby="user twitter" placeholder="twitter URL" value="@if($profile){{$profile->twitter}}@else{{old('twitter')}}@endif" />
                                    @error('twitter')
                                      <div class="show_message show_message-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="Linkedin"> Linkedin URL </label>
                                  <input type="text" class="form-control @error('Linkedin') is-invalid @enderror" id="linkedin" name="linkedin" 
                                   aria-describedby="user Linkedin" placeholder="Linkedin URL" value="@if($profile){{$profile->Linkedin}}@else{{old('linkedin')}}@endif" />
                                    @error('linkedin')
                                      <div class="show_message show_message-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="youtube"> Youtube Channel </label>
                                  <input type="text" class="form-control @error('youtube') is-invalid @enderror" id="youtube" name="youtube" 
                                   aria-describedby="user youtube" placeholder="Youtube URL" value="@if($profile){{$profile->youtube}}@else{{old('youtube')}}@endif" />
                                    @error('youtube')
                                      <div class="show_message show_message-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-website"> Save Profile </button>
                        </div>
                      </form>
                </div>
            </div>
            <hr/>
            <div class="d-flex justify-content-center my-5">
                <img
                src="@include("modals.profile_logo")"
                 alt="profile" class="img-fluid" width="200" >
            </div>
            <div class="d-flex justify-content-center">
                    <input type="file" name="image" id="customFile" class="image custom-file-input d-none">
                    <label class="btn btn-website btn-lg" for="customFile"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Upload Profile </label>
            </div>
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"> Profile Picture </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="img-container">
                <div class="row">
                <div class="col-md-8">
                <img id="image" src="">
                </div>
                <div class="col-md-4">
                <div class="preview"></div>
                </div>
                </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
        </div>
    @endsection
    @section('page-js')
        <script>
            let upload_profile = "{{route('upload_profile')}}";
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
        <script src="{{asset('js/profile.js')}}"></script>
    @endsection


{{-- </x-app-layout> --}}