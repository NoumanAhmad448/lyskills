@component('mail::message')
# HI 

{{ $body ?? '' }}


<div>
    Name  {{$name ?? ''}} 
</div>
<div>
    Email {{ $email ?? ''}} 
</div>
<div>
    Mobile {{ $mobile ?? '' }}
</div>
<div>
    Country 
    {{ $country ?? ''   }}
</div>
    

Thanks,<br>
{{ config('app.name') }}
@endcomponent