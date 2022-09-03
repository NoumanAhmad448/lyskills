<div>
   

    @php 
        $courses = $user->courses;
    @endphp

    @if(isset($courses) && $courses)
        <div > Total Course: {{ $courses->count()}} </div>
    @endif
    
    @if(isset($courses) && $courses)
        <div > Published Course: {{ $courses->where('status','published')->count()}} </div>
    @endif

    @if(isset($courses) && $courses)
        <div> Draft Courses: {{ $courses->where('status','draft')->count()}} </div>
    @endif

    @if(isset($courses) && $courses)
        <div> Pending Courses: {{ $courses->where('status','pending')->count()}} </div>
    @endif

    @if(isset($courses) && $courses)
        <div> Block
             Courses: {{ $courses->where('status','block')->count()}} </div>
    @endif

    <hr/>

</div>