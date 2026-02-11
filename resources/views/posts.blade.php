 @if (config('setting.all_posts'))
     @if (isset($post) && $post)
         <div class="container-fluid">
             <div class="row">
                 @include('sn.load_img')
                 <div class="col-md-12 content-main">
                     <div class="d-flex justify-content-end">
                         <a href="{{ route('all_public_posts') }}"
                             class="btn btn-lg btn-website">{{ __('homepage.posts.all') }}</a>
                     </div>
                 </div>
                 @include('sn.load_container')
                 <div class="col-md-8 offset-md-2 content-main">
                     <h2 class="my-2">{{ __('homepage.posts.recent') }}</h2>
                     <div class="row">
                         <div class="col-md-8 offset-md-2">
                             <img src="{{ config('setting.s3Url') . $post->upload_img }}"
                                 alt="{{ $post->f_name ?? '' }}" class="img-fluid" />
                         </div>
                     </div>
                     <h3 class="text-center mt-2 text-uppercase">
                         {{ $post->title }}
                     </h3>
                     <div class="mt-2">
                         {!! reduceWithStripping($post->message, 300) !!}
                     </div>
                     <a href="{{ route('public_posts', ['slug' => $post->slug]) }}"
                         class="btn btn-website my-2 float-right">{{ __('homepage.posts.read_more') }}</a>
                 </div>
             </div>
         </div>
     @endif
 @endif
