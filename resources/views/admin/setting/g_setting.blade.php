@extends('admin.admin_main')


@section('content')
    <h1> General Setting </h1> 
    <p> This Page is displaying the general setting of the website </p>

    <div class="container bg-light p-2 p-md-4">
        <div class="row my-1">
            <div class="col-md-4">
                <h5 > Website Name </h5>                
            </div>
            <div class="col-md-6">
                <div> {{ config('app.name') }} </div>                
            </div>
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5> Site URL </h5>                
            </div>
            <div class="col-md-6">                
                <div> {{ config('app.url') }} </div>
            </div>            
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5 class="py-2"> Website Title </h5>            
            </div>
            <div class="col-md-6">                
                <div> {{ __('messages.site_title') }} </div>
            </div>            
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5 class="py-2"> Email  </h5>                
            </div>
            <div class="col-md-6">                
                <div> {{ config('app.email') }} </div>
            </div>            
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5 class="py-2"> Allowed Video Formats  </h5>                
            </div>
            <div class="col-md-6">                
                <div> Webm, MP4, OGG </div>
            </div>            
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5 class="py-2"> Allowed Image Formats  </h5>
            </div>
            <div class="col-md-6">                
                <div> jpeg,png,jpg,gif,tif  </div>
            </div>            
        </div>
        <hr/>
        <div class="row my-1">
            <div class="col-md-4">
                <h5 class="py-2"> Time Zone  </h5>
            </div>
            <div class="col-md-6">                
                <div> {{ config('app.timezone') }}  </div>
            </div>            
        </div>
    </div>
    

@endsection 






@section("page-js")
    <script>
        $(function(){
            $('#a_g_setting').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
            $('.s_sub_menu').removeClass('d-none');
        });
    </script>
@endsection 