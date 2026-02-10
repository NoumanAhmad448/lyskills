<script>
    $(function() {
        $('.sec-container').on('change', '.edit_video', function() {
            const {
                video_url,
                progress_bar,
                form_data,
                current_file,
                c_f_form
            } = handleVideoUpload(this, 75);
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
                        // console.error(data[path]);
                        let path = data['path'];
                        let upload_vid = current_file.parents('.lecture_vid')
                            .first().find('source').first();
                        upload_vid.attr('src', path);
                        let media = data['media'];

                        progress_bar.parent().remove();
                        current_file.val('')
                    },
                    error: function(data) {
                        show_message('something went wrong');
                        progress_bar.parent().remove();
                        current_file.attr('disabled', false);
                        current_file.val('')


                    }
                });
            }
        });
    })
</script>
