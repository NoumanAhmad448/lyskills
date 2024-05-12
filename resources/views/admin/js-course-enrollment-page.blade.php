<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(function(){
        $('#p tfoot th').each( function () {
             var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
        $('#p').DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input#search_records', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
        language: {
        searchPlaceholder: "Search records"
    },
    "lengthMenu": [[20, 25, 50, -1], [20, 25, 50, "All"]]

        });

    });
    function unenroll_user(user_id,course_id)
    {
        if(confirm("Are you sure to unenroll this user? "))
        {
            axios.post("{!! route('xueshiXueshengPost') !!}", {
                student_id: user_id,
                course_id: course_id,
                action: "unenroll",
                type: "ajax",
                },
                {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }
                )
                .then(function (response) {
                    response = JSON.stringify(response);
                    if(response){
                        $(`#user_${user_id}`).remove()
                        show_message("{{ __('messages.user_enrolled_msg') }}")
                        location.reload()
                    }else{
                        console.error(response)
                    }
                })
                .catch(function (error) {
                    console.error(error);
            });
        }
    }
</script>
<script>
  $(function() {
    var search = $("#user_search");
    search.autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "{{route('search_unenrolle')}}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    q: request.term,
                    course_id: "{{ $course_id}}",
                },
                success: function( data ) {
                    response( data["data"] );
                }
            });
        },
        minLength: 2,
    select: function(event, ui) {
        course_id = "{{ $course_id }}"
        user_id = ui.item.id
        message = "{{ __('messages.confirmation_enroll') }}"
        message = message.replace(":this", ui.item.name)
        if(confirm(message))
        {
            axios.post("{!! route('xueshiXueshengPost') !!}", {
                student_id: user_id,
                course_id: course_id,
                action: "enroll",
                type: "ajax",
                },
                {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }
                )
                .then(function (response) {
                    response = JSON.stringify(response);
                    if(response){
                        show_message("{{ __('messages.user_enrolled_msgs') }}")
                        location.reload()
                    }else{
                        console.error(response)
                    }
                })
                .catch(function (error) {
                    console.error(error);
            });
        }
        }
    });
    });
</script>
<script>
    $('#enrollment').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
</script>
