@extends(config('setting.guest_blade'))
@section('page-css')
    <style>
        .star-red{
            color: #f00;
        }
    </style>
 {!! NoCaptcha::renderJs() !!}

@endsection
@section('content')
    <div class="jumbotron bg-website text-white text-center my-3">
        <h1> Contact Us </h1>
    </div>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4 ">
                <h2> Location </h2>
                <div> Ground floor Akram Plaza, Muslim Town, Ferozepur Road, near Baba Qulfi wala, Lahore </div>
            </div>
            <div class="col-md-4">
                <h2> Email </h2>
                <div> 
                    Lyskills.info@gmail.com
                </div>
            </div>
            <div class="col-md-4">
                <h2> Mobile Number </h2>
                <div> 
                    +92-334-9376619
                 </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @include('session_msg')
                <h2 class="text-center">
                    Directly Contact Us
                </h2>
                <form action="{{route('contact-us-post')}}" method="POST">
                    @csrf                   
                    <div class="form-group">
                      <label for="name"> Name<span class="star-red"> *</span> </label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="name"
                      value="{{old('name')}}">
                      @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="form-group">
                      <label for="email"> Your Email<span class="star-red"> *</span> </label>
                      <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email"
                      value="{{old('email')}}">
                      @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="form-group">
                      <label for="mobile"> Mobile Number </label>
                      <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="mobile"
                      value="{{old('mobile')}}">
                      @error('mobile')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="form-group">
                      <label for="country"> Country </label>
                      <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" placeholder="country"
                      value="{{old('country')}}">
                      @error('country')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>

                    <div class="form-group">
                      <label for="subject"> Subject<span class="star-red"> *</span> </label>
                      <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject"
                      value="{{old('subject')}}">
                      @error('subject')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
            
                    <div class="form-group">
                      <label for="body"> Email Body<span class="star-red"> *</span></label>
                      <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" placeholder="body" rows="20">{{old('body')}}</textarea>
                      @error('body')
                            <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>    
                    {!! NoCaptcha::display() !!}
                    @if ($errors->has('g-recaptcha-response'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-website btn-lg mt-3"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                         Send Message </button>
                  </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function(){
            $('input,textarea,select').click(function(){
                $('input,textarea,select').removeClass('is-invalid');
                $('.alert').fadeOut();
            });
        });
    </script>
@endsection