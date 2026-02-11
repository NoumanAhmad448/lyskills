@if (config('setting.course_nav'))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white text-dark">
            @if ($course->categories_selection)
                <li class="breadcrumb-item text-capitalize"> <a
                        href="{{ route('user-categories', ['category' => $course->categories_selection]) }}">
                        {{ $course->categories_selection ?? '' }} </a> </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page"> {{ $course->slug ?? '' }} </li>
        </ol>
    </nav>
@endif
