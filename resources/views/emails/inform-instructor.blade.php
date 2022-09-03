@component('mail::message')
# Hi {{$ur_name}}

A student <b> {{$u_name}} </b> has purchased the <b> {{$course_name}} </b> course from <b> {{ config('app.name') }}</b>. For further information, you may visit your dashboard 
on <b> {{ config('app.name')}} </b>.

Please visit our website at 
@component('mail::button', ['url' => config('app.url')])
    {{ config('app.name') }} website
@endcomponent

You may visit the following link to check your course 
@component('mail::button', ['url' => $course_link])
{{ $course_name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
