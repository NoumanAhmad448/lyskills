@component('mail::message')
# hi nomi

This is just a testing email. Please ignore
@component('mail::button', ['url' => 'www.google.com'])
Button Text
@endcomponent

Thanks,<br>
@endcomponent
