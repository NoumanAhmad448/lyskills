@component('mail::message')
<b> Hello  </b> {{ $name }}

The status of your course {{ $course_name }} has been changed to {{ $course_status }}. Please login to 
our system and proceed with your course. 

@component('mail::button', ['url' => config('app.url')])
Lyskills.com 
@endcomponent


@endcomponent
