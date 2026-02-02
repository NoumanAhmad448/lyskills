$(function() {
    $('#lang ,#select_category, #select_level ').select2();

    $( ".landing_form" ).on( "submit", function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        let url = $(this).attr('url');
        let s_t_err = $(this).find('#title_err');
        let s_d_err = $(this).find('#desc_err');
        let s_c_level = $(this).find('#c_level');
        let s_category = $(this).find('#category_level');
        let show_status = $(this).find('#show_status');
        let lang_err = $(this).find('#lang_err');

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                let status = data['status'];
                show_status.text(status);
                setTimeout(() => {
                    show_status.text('');
                }, 5000);
            },
            error: function(data){
                let errs  = JSON.parse(data.responseText).errors;
                let title_err = errs['course_title'];
                let description = errs['course_desc'];
                let select_level = errs['select_level'];
                let select_category = errs['select_category'];
                let lang = errs['lang'];

                s_t_err.text(title_err);
                s_d_err.text(description);
                s_c_level.text(select_level);
                s_category.text(select_category);
                lang_err.text(lang);
                setTimeout(() => {
                    if(s_t_err){
                        s_t_err.text('');

                    }
                    if(s_d_err){

                        s_d_err.text('');
                    }
                    if(s_c_level){
                        s_c_level.text('');
                    }
                    if(s_category){
                        s_category.text('');

                    }
                    if(lang_err){
                        lang_err.text('');

                    }
                }, 10000);

            }
        });
    });

    $('#landing_page').removeClass('text-info').addClass('bg-website text-white');

    $('.upload_img').on('change',function(){
        let url = $(this).attr('url');
        let con = $(this).parents('.img_con').first();
        let p_con = con.find('.p_bar_con');
        let p_bar = p_con.children('.p_bar');
        var file = this.files[0];
        var fileType = file["type"];
        var validImageTypes = ["image/gif", "image/jpeg","image/jpg", "image/png",'image/tif'];
        let img_err = con.find('.img_err');
        let course_img = $('.course_img');
        let current = $(this);

        let formData = new FormData($(this).parents('form').first().get(0));
        if ($.inArray(fileType, validImageTypes) < 0) {
            img_err.text('Please upload an image of jpg,jpeg,png,tif,gif format');
            setTimeout(() => {
                img_err.text('');
            }, 10000);
        }else if(file['size']/1024/1024 == 10){
            img_err.text('Image size must be less than 10MB');
            setTimeout(() => {
                img_err.text('');
            }, 10000);
        } else{
            p_con.removeClass('d-none');
            current.attr('disabled',true);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    let percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                        p_bar.attr('aria-valuenow',percentComplete);
                        p_bar.text(percentComplete+'%');
                        p_bar.css('width',percentComplete+'%')
                        p_bar.css('display','block')
                }
                }, false);

                return xhr;
            },
            url: url,
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                let img_path = result['img_path'];
                course_img.attr('src', img_path);
                p_con.addClass('d-none');
                current.attr('disabled',false);
                current.val(null);

            },
            error: function(d){
                p_bar.attr('aria-valuenow',0);
                p_bar.text(0+'%');
                p_bar.css('width',0+'%')
                p_con.addClass('d-none');
                current.attr('disabled',false);
                $('.upload_img').val(null)
                popup_message(d)
                current.val("")
            }
        });

    }
    });



});