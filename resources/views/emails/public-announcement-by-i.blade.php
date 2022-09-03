@component('mail::message')
# Hi

{{ $body ?? '' }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
