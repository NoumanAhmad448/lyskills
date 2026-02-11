<div class="d-md-flex justify-content-end align-items-md-center">
    @auth
        <a href="{{ route('dashboard') }}" class="ml-3 mt-4 mt-md-0"> Instructor </a>
        <a href="{{ route('get-wishlist-course') }}" class="ml-3 text-website" style="font-size: 2rem" title="wishlist courses">
            <i class="fa fa-heart" aria-hidden="true"></i>
        </a>
    @else
        <a href="{{ route('dashboard') }}" class="ml-3 mt-5 mt-md-3 text-dark">
            {{ __('Teach on Lyskills') }} </a>
        @endif
    </div>
    </div>
