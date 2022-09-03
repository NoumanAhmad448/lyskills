@component('mail::message')
# Hi {{ $name }}

Congtratulation {{ $name }}! You have been successfully enrolled in {{$course_name}}. Please visit the course
page and start watching the course content. 

@component('mail::button', ['url' => $course_url])
 Course Link
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
