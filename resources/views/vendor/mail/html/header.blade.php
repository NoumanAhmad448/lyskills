<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if(file_exists(asset('img/logo.jpg')))
<img src="{{ asset('img/logo.jpg')}}" class="logo" alt="Lyskills Logo">
@else
{{ config('app.name')}}
@endif 
</a>
</td>
</tr>
