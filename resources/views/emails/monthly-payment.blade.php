@component('mail::message')
# HI {{$name}}

We have sent you your monthly payment. Please check our website for further information.
Your {{ $email }} has registered on our website. 
@component('mail::button', ['url' => '{{config("app.url")}}'])
 {{config('app.name')}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
