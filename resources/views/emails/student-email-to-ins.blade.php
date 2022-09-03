@component('mail::message')
# HI {{$ins_name}}

A student <b> {{ $name }} </b> with email <b> {{ $email }} from {{ config('app.name') }} has 
    to say something about your course {{ $course_name }} 

{{$body}}


If you need to contact with this student. Please reponse to his email address. 
Thanks,<br>
{{ config('app.name') }}
@endcomponent
