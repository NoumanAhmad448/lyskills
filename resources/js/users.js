
        $(function(){  
        $('#users').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
        $('.delete').click(function(){
            if(confirm('Do you want to delete this user? Deleting this user might cause some issue')){
                let del = $(this);
                let url = del.attr('link');
                if(url){
                    $.ajax({
                        url: url,
                        type: 'delete',
                        dateType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(d){
                            show_message(d['status']);
                            del.parents('.u_record').first().remove();
                        }

                    });
                }

            }

        });

        $('#sorting').change(function(){
            $(this).parents('form').first().submit();
        });
        });

        $( "#search_item" ).keypress(function( ) {        
            if ( event.which == 13 && $(this).val() !== '') {
                $(this).parents('form').first().submit();
            }
        });
