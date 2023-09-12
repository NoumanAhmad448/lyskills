$('.rating').each(function (index) {
    if (index < rating) {
        $(this).addClass('text-warning');
    } else {
        $(this).removeClass('text-warning');
    }
});

$('#menu').click(function () {
    if ($('#list').hasClass('d-none')) {
        $('#list').removeClass('d-none');
    } else {
        $('#list').addClass('d-none');
    }
});

$(".rating").click( function(){
    let rating_no = $(this).attr('no');
    $.ajax({
        headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    url: rating_url,
    data: {rating_no:  rating_no, course: course_slug },
    dataType: "json",
    success: function(result){
        if(result.message){
            $('.rating').each(function(index){
                if(index<rating_no){
                    $(this).addClass('text-warning');
                }else{
                    $(this).removeClass('text-warning');
                }
            })
        }
    }
});
});