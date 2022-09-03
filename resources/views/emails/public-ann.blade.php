@component('mail::message')
Hi {{ $name}}

{!!$body!!}

@component('mail::button', ['url' => 'https://lyskills.com' ])
Lyskills
@endcomponent



Thanks,<br>
{{ config('app.name') }}
@endcomponent
