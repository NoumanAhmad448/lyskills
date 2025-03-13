$(function() {
    $('#msg').removeClass('text-info').addClass('bg-website text-white');

    $('.final_form').submit(function(e){
        e.preventDefault();
        let c = $(this);
        let url = c.attr('url');
        let data = c.serialize();
        let wel_err = $('#wel_err');
        let congo_err = $('#congo_err');
        let success_msg = $('.success_msg');

        if(url){
            $.ajax({
                data: data,
                url: url,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(d){
                    success_msg.text(d['status']);
                    setTimeout(() => {
                        success_msg.text('');

                    }, 10000);
                },
                error: function(d){
                    let err = JSON.parse(d.responseText).errors;
                    let wel_msg = err['wel_msg'];
                    let congo_msg = err['congo_msg'];
                    if(wel_msg){
                        wel_err.text(wel_msg[0]);
                    }
                    if(congo_msg){
                        congo_err.text(congo_msg);
                    }

                    setTimeout(() => {
                        wel_err.text('');
                        congo_err.text('');

                    }, 10000);
                },
                dataType: 'json'
            })
        }
    });
});