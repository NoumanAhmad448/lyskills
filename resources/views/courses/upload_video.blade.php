<script>
    $(function() {
        $('.sec-container').on('change', '.upload_video', function() {
            const {
                video_url,
                progress_bar,
                form_data,
                current_file,
                c_f_form
            } = handleVideoUpload(this)
            if (video_url) {
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
                        return createProgressXhr(progress_bar);

                    },
                    success: function(data) {
                        current_file.attr('disabled', false);
                        if (data['err']) {
                            show_message(data['err'])
                        } else {
                            let path = data['path'];
                            let upload_vid = current_file.parents(
                                '.upload_video_con').first();
                            let media = data['media'];
                            let video_btn = current_file.parents(
                                    '.upload_video_con').prev('.lecture_container')
                                .find('.lec_content').first();
                            video_btn.removeClass('lec_content').addClass(
                                'v_c_vid');

                            videoResponse(data, upload_vid, path, media)
                            current_file.val('');
                        }
                    },
                    error: function(data) {
                        current_file.val('');
                        progress_bar.parent().remove();
                        current_file.attr('disabled', false);
                        let show_err = c_f_form.children('.video_err');
                        let res = JSON.parse(data);
                        $(".progress").each(function() {
                            $(this).hide()
                        })
                        if (res['err']) {
                            show_message(res['err'])
                        } else {
                            data = JSON.parse(data['responseText'])['errors'];
                            show_err.removeClass('d-none').addClass('d-block').text(
                                data['upload_video']);
                            setTimeout(function() {
                                show_err.addClass('d-none').removeClass(
                                    'd-block');
                            }, 15000);
                        }
                    }
                });
            }
        });
    });
</script>
