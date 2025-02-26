@php

$id = $prop['id'] ?? '';
$hide_el = $prop['hide_el'] ?? 'default';
debug_logs("script component");
debug_logs($id);
@endphp

<script>
    $(document).ready(function(){
        const {{$id}}loader = $('.{{$id}}loader');
        const {{$id}}hide_el = $('#{{$hide_el}}');

        debug_logs("loader count => "+{{$id}}loader.length)
        if({{$id}}loader.length > 0){
            $.each({{$id}}loader, function(index, item) {
                debug_logs("inside each")
                debug_logs(item)
                $(item).addClass("hidden")
            });
        }
        else if({{$id}}loader){
            {{$id}}loader.addClass("hidden");
        }
        if({{$id}}hide_el.length){
            {{$id}}hide_el.removeClass("hidden")
        }
        debug_logs("loader id: "+'#{{$id}}')
    })
</script>
