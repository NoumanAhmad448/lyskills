@extends(config('setting.guest_blade'))
@section('page-css')
    <style>
        .star-red{
            color: #f00;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>
            Send Email To Instructor
        </h1>
    </div>

    <div class="container my-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @include('session_msg')
                <h2 class="text-center">
                   Email to Your Course Instructor
                </h2>
                <form action="{{route('email_to_ins_post')}}" method="POST">
                    @csrf     
                    
                    <div class="form-group">
                        <label for="course">Select Course</label>
                        <select class="custom-select @error('course') is-invalid @enderror" name="course">
                            @if(count($c_titles))
                            @foreach ($c_titles as $title)
                            <option value="{{$title}}"> {{ str_replace('-',' ',$title) }} </option>                                                                    
                            @endforeach
                            @endif
                        </select>  
                        <span class="text-danger my-1 d-block">If no course is found in the select option which mean you are not enrolled in any course </span>
                        @error('course')
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
                    <button type="submit" class="btn btn-website btn-lg">Send Email </button>
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