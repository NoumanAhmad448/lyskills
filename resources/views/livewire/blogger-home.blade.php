<div>
    <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> All FAQ </h5>
              <p class="card-text"> {{ $t_faq }}</p>
              @if(isset($setting) && $setting->isBlog)
                <a href="{{route('blogger_c_faq')}}" class="btn btn-info"> Create FAQ </a>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> All Posts </h5>
              <p class="card-text"> {{ $t_post }} </p>
              @if(isset($setting) && $setting->isFaq)
                <a href="{{route('blogger_c_p')}}" class="btn btn-info"> Create Post</a>
              @endif
            </div>
          </div>
        </div>
      </div>
</div>
