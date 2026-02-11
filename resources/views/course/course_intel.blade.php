<h1 class="text-capitalize" style="font-weight: bold!important"> {{ $course->course_title ?? '' }}
</h1>
<div class="mt-2" class="text-justify">
    {{ reduceCharIfAv($course->description ?? '', 200) }}
</div>
<div class="mt-2 text-uppercase">
    Created by <a class="text-warning" href="#profile"> {{ $course->user->name ?? '' }} </a>
</div>

@if ($rating_avg)
    <div class="d-flex align-items-center">
        <section id="rating" class="d-flex align-items-center" style="cursor: pointer">
            <span class="fa fa-2x fa-star rating" no="1"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="2"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="3"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="4"></span>
            <span class="fa fa-2x fa-star ml-1 rating" style="text-size: 1.3rem;" no="5"></span>
        </section>
        <section class="ml-1">
            {{ $rated_by_students }} Students
        </section>
    </div>
@endif

<div class="mt-2">
    Last updated {{ LyskillsCarbon::parse($course->updated_at, true) ?? '' }}
</div>
@if (!empty($total_en) && config('setting.course_enrollment_count'))
    <div class="m2-1">
        Enrollment: {{ $total_en ?? '' }}
    </div>
@endif
@if ($course && $course->lang && $course->lang->name ?? '')
    <div class="m2-1">
        Language: {{ $course->lang->name ?? '' }}
    </div>
@endif
<div class="mt-2">
    <section class="d-flex">
        @if (config('setting.course_desc_wishlist_btn'))
            <form action="{{ route('wishlist-course-post', ['slug' => $course->slug]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-light">
                    @auth
                        @if (WishList::where('user_id', auth()->id())->where('c_id', $course->id)->first())
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        @else
                            <i class="fa fa-heart-o text-website" aria-hidden="true"></i>
                        @endif
                    @endauth
                    @guest
                        <i class="fa fa-heart-o text-website" aria-hidden="true"></i>
                    @endguest
                    Wishlist
                </button>
            </form>
        @endif
        @if (config('setting.course_desc_share_btn'))
            <div link="{{ route('user-course', ['slug' => $course->slug]) }}" id="share_course"
                class="btn btn-light ml-2"> <i class="fa fa-share-square-o" aria-hidden="true"></i>
                Share
            </div>
        @endif
        @if (config('setting.course_desc_gift_btn'))
            <a href="" class="btn btn-light ml-2"> <i class="fa fa-gift" aria-hidden="true"></i>
                Gift Course
            </a>
        @endif
    </section>
</div>
