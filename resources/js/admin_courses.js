$(function(){

        
    $('#courses').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
    $('#sorting').change(function(){
            if($(this).val() !== ''){
                $(this).parents('form').first().submit();
            }
        });

        $( "#search_item" ).keypress(function( ) {
            if ( event.which == 13 && $(this).val() !== '') {
                $(this).parents('form').first().submit();
            }
        });


        $('#update').click(function(){
            let status = $('#status').val();   
            let url = $('#course_status_change').val();             
            if(status !== ""){
                course_no = $('#courses_nos').val();
                if(course_no !== ""){
                    $.ajax({                            
                        type: 'post',
                        url: url,
                        dataType: 'json',
                        data: {'course_no': course_no, 'status': status },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        ,success: d => {
                              alert(d);
                              location.reload();
                        },error: d => {
                            errors = JSON.parse(d.responseText)['errors'];
                            console.log(errors);
                        }
                    });
                }else{
                    alert("Please select a course");
                }
            }else{
                alert('Please choose the status');
            }
        });

        $('.course_no').change(function(){
            let current_el = $(this);                    
            if(current_el.is(':checked')){
                $('#courses_nos').val(current_el.attr('values'));
            }
        });
    });