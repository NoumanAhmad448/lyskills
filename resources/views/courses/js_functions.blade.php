<script>
    function createProgressXhr(progressBar) {
        const xhr = new window.XMLHttpRequest();

        xhr.upload.addEventListener('progress', function(evt) {
            if (!evt.lengthComputable) return;

            const percent = Math.round((evt.loaded / evt.total) * 100);

            progressBar
                .attr('aria-valuenow', percent)
                .css('width', percent + '%')
                .html('<b> Uploading ' + percent + '% </b>');
        });

        return xhr;
    }

    function p_elment(width = 100) {
        return `
                        <div class="progress my-3" style="width: ${width}%; height: 40px;">
                            <div class="p_bar progress-bar bg-info progress-bar-striped"
                                role="progressbar"
                                style="width: 0%;"
                                aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                `;
    }

    function handleVideoUpload(inputEl, width = 100) {
        const $input = $(inputEl);
        const file = inputEl.files[0];
        if (!file) return;

        const $form = $input.closest('.upload_video__form');
        const formData = new FormData($form[0]);
        const $fileErr = $input.parent().find('.file_err');
        const $container = $input.closest('.upload_video_con');

        const allowedTypes = [
            'video/mp4',
            'video/ogg',
            'video/webm'
        ];

        // reset error state
        $fileErr.removeClass('d-block').addClass('d-none').text('');
        $input.removeClass('is-invalid');

        /* ---------- VALIDATION ---------- */

        if (!allowedTypes.includes(file.type)) {
            showFileError(
                $input,
                $fileErr,
                'Only MP4, OGG, WEBM formats are allowed'
            );
            return;
        }

        const sizeInGB = file.size / 1024 / 1024 / 1024;
        if (sizeInGB > 4.2) {
            showFileError(
                $input,
                $fileErr,
                'File size cannot exceed 4GB'
            );
            return;
        }

        /* ---------- UI + UPLOAD ---------- */

        $input.prop('disabled', true);

        const videoUrl =
            $form.attr('url') && $form.attr('url').trim() !== '' ?
            $form.attr('url').trim() :
            $input.attr('video_url');


        $container.append(p_elment(width));
        const $progressBar = $container.find('.p_bar').last();

        return {
            video_url: videoUrl,
            progress_bar: $progressBar,
            form_data: formData,
            current_file: $input,
            c_f_form: $form
        };

    }

    function showFileError($input, $fileErr, message) {
        $fileErr.addClass('d-block').removeClass('d-none').text(message);
        $input.addClass('is-invalid');

        setTimeout(() => {
            $fileErr.removeClass('d-block').addClass('d-none').text('');
            $input.removeClass('is-invalid');
            $input.val('');
        }, 10000);
    }

    function videoResponse(data, upload_vid, path, media) {
        path = s3Url + path;
        let response = `<section class="lecture_vid row p-3">
                                                <div class="col-md-9">
                                                <div class="form-check my-3">
                                                        <input class="form-check-input is_free" type="checkbox"
                                                        media_id="${data['media']}"
                                                            id="is_free_${data['media']['id']}"
                                                         name="set_free"
                                                        ${data['media']['is_free'] ? "checked" : ''}
                                                        >
                                                        <label class="form-check-label" for="set_free">
                                                            set video download
                                                        </label>
                                                    </div>
                                                <div class="form-check my-3">
                                                        <input class="form-check-input is_free" type="checkbox"
                                                        media_id="${data['media']['id']}"
                                                        id="is_download_${data['media']}" name="is_download"
                                                        ${data['media']['is_download'] ? "checked" : ''}
                                                        >
                                                        <label class="form-check-label" for="is_download">
                                                            set video free
                                                        </label>
                                                </div>`
        if ({{ config('setting.en_showing_vid_val') ? 1 : 0 }}) {
            $response += `
                                                <section class="d-flex justify-content-start align-items-center my-3">
                                                    <div class="col-3" name="access_duration">
                                                        <label for="date_time">Until Valid Date?</label>
                                                        <input p_d="${data['media']['access_duration']}"
                                                        value="${data['media']['access_duration']}" type="text"
                                                        class="form-control date-picker
                                                        access_duration_${data['media']['course_id']}" autocomplete="off"
                                                        id="date_time" name="date_time">
                                                    </div>
                                                    <button class="saveAccess btn btn-info" style="margin-top: 2rem"
                                                    data-course-id="${data['media']['course_id']}"
                                                    data-lecture-id="${data['media']['lecture_id']}" class=''>Save</button>
                                                </section>`
        }
        response += `
                            <div class="d-flex">
                                <video width="500" height="240" controls oncontextmenu="return false;" preload="auto">
                                    <source src="${path}" type="${media['f_mimetype']}">
                                </video>
                            </div>
                            <section class="mt-2">
                                <h3 class="d-none d-md-block ml-3"> ${data['f_name']} </h3>
                                                                                    <section class="d-flex upload_video_con">

                                <form url="${data['delete']}">
                                    <button type="button" class="btn btn-danger del_media"> Delete lecture </button>
                                </form>
                                <form
                                    url="${data['edit_video']}"
                                    class="ml-2 edit_form upload_video__form">
                                    <input type="file" name="edit_video"
                                        class="custom-file-input edit_video d-none"
                                        id="edit_video${data['media']['id']}">
                                    <label for="edit_video${data['media']['id']}" class="btn btn-website"> Edit Lecture
                                    </label>
                                </form>
                                </section>
                            </section>
                            </div>
                        </section>
                                        `
        upload_vid.replaceWith(response);
    }
</script>
