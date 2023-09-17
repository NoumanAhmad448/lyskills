$(function () {
    $('#add_sec, .add_material').tooltip();
    $('body').addClass('min-vh-100 d-flex flex-column');
    $('.footer').addClass('mt-auto');


    $(".sec-container").on("change",".is_free",function () {
        url = $(this).attr("url")
        media_id = $(this).attr("media_id")

        set_free = $(`#is_free_${media_id}`).is(":checked") ? 1 : 0

        body_part = { set_free: set_free }
        body_part['set_download'] = $(`#is_download_${media_id}`).is(":checked") ? 1 : 0

        body = body_part
        if (debug) {
            console.log(body)
        }

        $.ajax({
            url: url,
            type: "post",
            data: body,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        })
            .done(function (e) {
                show_popup(`Requested operation has been performed`)
                $("#close-modal").removeAttr("onclick")
            })
            .fail(function () {
                console.error(err)

            })

    })

})

function cancel(event){
    let current_elem = $( event.target );
    let prev_val = current_elem.attr('prev_val');
    let parent_form  = $(current_elem.parents('form'))
    if( parent_form!== 'undefined'){
        parent_form.replaceWith(`<div class="sec_title ml-md-2">
           ${prev_val}
            <span class="sec_title_edit ml-2" >
                <i class="las la-pen"></i>
            </span>
    </div>`);
    }else{
        console.error('could not find form element')
    }
}
function cancel_title(event){
    let current_elem = $( event.target );
    let parent_form  = $(current_elem.parents('form'))
    if( parent_form!== 'undefined'){
        parent_form.replaceWith(`<div class="btn website add_title">
            <i class="las la-plus"></i>
            Add Title
        </div>`);
    }else{
        console.error('could not find form element')
    }
}

function reduceTextLen(input_txt,limit=50){
    if(input_txt.length > limit){
        return input_txt.substr(0,limit) + "...";
    }
    return input_txt;
}

$(function(){
    $("body").on("change","#set_all_video",function () {
        url = $(this).attr("url")

        set_free = $(this).is(":checked") ? 1 : 0

        body_part = { set_free: set_free }

        body = body_part
        if (debug) {
            console.log(body)
        }
        $('.loading-section').addClass('loader').fadeIn();
        $('#loading').fadeIn();
        $.ajax({
            url: url,
            type: "post",
            data: body,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        })
            .done(function (e) {
                $('#loading', '.loading-section').fadeOut();
                $('.loading-section').removeClass('loader').fadeOut();
                show_popup(`Requested operation has been performed`)
            })
            .fail(function () {
                $('#loading', '.loading-section').fadeOut();
                $('.loading-section').removeClass('loader').fadeOut();
                console.error(err)

            })

    })

})