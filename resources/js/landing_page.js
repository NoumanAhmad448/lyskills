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


            },
            error: function(d){
                p_bar.attr('aria-valuenow',0);
                p_bar.text(0+'%');
                p_bar.css('width',0+'%')
                p_con.addClass('d-none');
                current.attr('disabled',false);

                popup_message(d)
            }
        });

    }
    });


    $('.upload_vid').on('change',function(){
            let current_file = $(this);
            let c_f_form  = current_file.parents('.course_vid').first();
            var form_data = new FormData(current_file.parents('form').first().get(0));
            let file = this.files[0];
            let file_err = $('.vid_err');
            let vid_p_con = $('.vid_p_con');
            let vid_p_bar = $('.vid_p_bar');
            var video_img = $('.video_img');
            if(file){
                if(! file.type.startsWith("video")){
                    file_err.text('Only video files are allowed');
                    current_file.addClass('is-invalid');
                    setInterval(function(){
                        file_err.text('');
                        current_file.removeClass('is-invalid');
                    },10000);
                }
                else if(parseInt(file.size/1024/1024) > 4096){
                    file_err.text('File size cannot exceed from 4GB');
                    current_file.addClass('is-invalid');
                    setInterval(function(){
                        file_err.text('');
                        current_file.removeClass('is-invalid');
                    },10000);

                }
                else{
                    current_file.attr('disabled',true);
                    let video_url = current_file.attr('url');
                    vid_p_con.removeClass('d-none');
                    if(video_url){
                        $.ajax({
                            url: video_url,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: form_data,
                            contentType: false,
                            processData: false,
                            dataType: 'JSON',

                            xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    let c_progress = Math.round(percentComplete * 100);
                                    vid_p_bar.attr('aria-valuenow',c_progress);
                                    vid_p_bar.css('width',c_progress+'%');

                                    vid_p_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                                }
                            }, false);
                            return xhr;
                            },
                            success: function(data){
                                current_file.attr('disabled',false);
                                vid_p_con.addClass('d-none');

                                var video_path = data['video_path'];
                                var video_type = data['video_type'];

                                video_img.replaceWith(`
                                <video width="450" height="350" controls>
                                    <source src="${video_path}" type="${video_type}">
                                </video>
                                `);


                                location.reload();
                            },
                            error: function(data){
                                current_file.attr('disabled',false);
                                vid_p_con.addClass('d-none');
                                vid_p_bar.attr('aria-valuenow',0);
                                vid_p_bar.css('width',0+'%');

                                vid_p_bar.html('<b> Uploading  ' + 0 + '% </b>');

                                if(typeof data == "json"){
                                    data = JSON.parse(data['responseText']);
                                    let course_vid= data['course_vid']['course_vid'];
                                    popup_message(course_vid)
                                }else{
                                    popup_message(err_msg)
                                }

                                setTimeout(function() {
                                    file_err.text('');
                                }, 10000);
                            }
                    });
                }
                }
            }
        });

});