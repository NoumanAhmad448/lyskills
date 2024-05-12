$(function() {

   

    $('.ct_btn').click(function(){
        
        let c = $(this);
        let p = c.parents('.create_btn_row').first();
        
        if(p.nextAll('.c_con').length == 0){
            p.after(`
                <section class="c_con" >
                <div class="row">
                    <div class="col-12">
                        <div class="float-right cursor_pointer text-danger close_form icon-sm mt-3">
                            <i class="las la-times-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="coupon_no">Coupon</label>
                    <input type="text" class="form-control" id="coupon_no" placeholder="Coupon" name="coupon_no">
                    <small class="form-text text-muted">write any specific word of your choice and share it with others
                        to let them access your course at specific cost or totally free.
                    </small>
                </div>
                <div class="form-group">
                    <div class="col-3">
                        <label for="date_time">Until Valid Date?</label>
                        <input type="datetime" class="form-control" id="date_time" name="date_time">
                    </div>
                    <div class="col-3">
                        <label for="no_of_coupons">Allowed Coupons?</label>
                        <input type="number" class="form-control" id="no_of_coupons" name="no_of_coupons">
                    </div>
                    <div class="col-3">
                        <label for="percent"> Set Percentage %</label>
                        ${percentage_select}
                    </div>
                </div>
                <div class="err_msg text-danger my-2"> </div>
                <button type="submit" class="btn btn-info"> Create </button>

                </section>
            `);
        }

    });

    $('.coupon').on('click','.close_form', function(){
        if(confirm('Do you want to close the form?')){
            $(this).parents('.c_con').remove();

        }
    });



    $('.coupon').submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        let url = $(this).attr('url');
        let c = $(this);
        let c_con= c.find('.c_con');
        let show_e_msg = $('.err_msg');
        var pricing_con = $('.pricing');
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function(d){
                pricing_con.append(`
                    <form url="${d['edit']}" class="edit_coupon mt-3">
                        <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="coupon_no" placeholder="Coupon" name="coupon_no" value="${d['coupon']}">
                                </div>
                            </div>
                            <div class="col-2 col-md-1">
                                <div class="btn btn-danger del_coupon" url="${d['delete']}"> Delete </div>
                            </div>
                            <div class="ml-3 ml-md-0 col-6 col-md-1">
                                <div class="submit btn btn-info mr-1" > Update </div>
                            </div>
                        </div>
                        </div>
                    </form>
                `);
                if(!coupon_form){
                    c_con.remove();
                }else{
                    show_popup("coupon has been created")
                }
            },
            error: function(d){
                let err = JSON.parse(d.responseText).errors;
                let p_err = err['coupon_no'];
                if(p_err){
                    show_e_msg.text(p_err);
                }
                setTimeout(() => {
                    show_e_msg.text('');
                }, 10000);

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON'
        });
    });

    $('.pricing').on('submit','.edit_coupon', function(e){
        e.preventDefault();
        let data = $(this).serialize();
        let url = $(this).attr('url');
        let c = $(this);
        let c_con= c.find('#coupon_no');
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function(d){
                c_con.attr('value',d['coupon']);
                show_message('updated');
            },
            error: function(d){
                let err = JSON.parse(d.responseText).errors;
                let p_err = err['coupon_no'];
                if(p_err){
                    show_message(p_err);
                }
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON'
        });
    });      
    
    
    $('.pricing').on('click','.del_coupon', function(e){
    if(confirm('do you want to delete this coupon?')){
        let url = $(this).attr('url');
        let edit_coupon  = $(this).parents('.edit_coupon').first();
        $.ajax({
            url: url,
            type: 'delete',
            success: function(d){
                show_message(d['status']);
                edit_coupon.remove();
            },
            
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON'
        });
    }



    });

    $('#promotion').removeClass('text-info').addClass('bg-website text-white');


    $("#is_free").change(()=>{
        if($("#is_free").is(':checked')){
            $("#set_free").addClass("d-none").removeClass("d-block")
        }else{
            $("#set_free").addClass("d-block").removeClass('d-none')
        }
    })

    $(".update-coupon").click(function(){
        $("#update-coupon-form").modal({
            keyboard: true,
            focus: true,
            show: true
        })

        $(`#modal_coupon_no`).val($(this).attr("coupon_no"))
        $(`#modal_date_time`).val($(this).attr("date_time"))

        if($(this).attr("is_free") == 1)
        {
            $(`#modal_is_free`).prop("checked",true)
        }

        $(`#modal_percentage`).val($(this).attr("percentage"))
        $(`#modal_no_of_coupons`).val($(this).attr("no_of_coupons"))
        $(`#coupon_id`).val($(this).attr("id"))
    })

    $('.coupon_update').submit(function(e){
        e.preventDefault();
        let data = $(this).serialize();
        let url = $(".coupon").attr('url');
        let c = $(this);
        let c_con= c.find('.c_con');
        let show_e_msg = $('.err_msg_update');
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function(d){
                if(!coupon_form){
                    c_con.remove();
                }else{
                    $("#update-coupon-form").modal("hide")
                    show_popup("coupon has been updated")
                }
            },
            error: function(d){
                let err = JSON.parse(d.responseText).errors;
                let p_err = err['coupon_no'];
                if(p_err){
                    show_e_msg.text(p_err);
                }
                setTimeout(() => {
                    show_e_msg.text('');
                }, 10000);

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON'
        });
    });
});