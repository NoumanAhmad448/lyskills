$(function(){

    $( ".delete_course" ).click(function() {
        let get_id = $(this).attr('id');
        if(get_id){
            $('.delete').attr('onClick',`$('.${get_id}').submit();`);
            $('#course_delete').modal('show');               
        }
        
    });
});