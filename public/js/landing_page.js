/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/landing_page.js ***!
  \**************************************/
$(function () {
  $('#lang ,#select_category, #select_level ').select2();
  $(".landing_form").on("submit", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(this).attr('url');
    var s_t_err = $(this).find('#title_err');
    var s_d_err = $(this).find('#desc_err');
    var s_c_level = $(this).find('#c_level');
    var s_category = $(this).find('#category_level');
    var show_status = $(this).find('#show_status');
    var lang_err = $(this).find('#lang_err');
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        var status = data['status'];
        show_status.text(status);
        setTimeout(function () {
          show_status.text('');
        }, 5000);
      },
      error: function error(data) {
        var errs = JSON.parse(data.responseText).errors;
        var title_err = errs['course_title'];
        var description = errs['course_desc'];
        var select_level = errs['select_level'];
        var select_category = errs['select_category'];
        var lang = errs['lang'];
        s_t_err.text(title_err);
        s_d_err.text(description);
        s_c_level.text(select_level);
        s_category.text(select_category);
        lang_err.text(lang);
        setTimeout(function () {
          if (s_t_err) {
            s_t_err.text('');
          }
          if (s_d_err) {
            s_d_err.text('');
          }
          if (s_c_level) {
            s_c_level.text('');
          }
          if (s_category) {
            s_category.text('');
          }
          if (lang_err) {
            lang_err.text('');
          }
        }, 10000);
      }
    });
  });
  $('#landing_page').removeClass('text-info').addClass('bg-website text-white');
  $('.upload_img').on('change', function () {
    var url = $(this).attr('url');
    var con = $(this).parents('.img_con').first();
    var p_con = con.find('.p_bar_con');
    var p_bar = p_con.children('.p_bar');
    var file = this.files[0];
    var fileType = file["type"];
    var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png", 'image/tif'];
    var img_err = con.find('.img_err');
    var course_img = $('.course_img');
    var current = $(this);
    var formData = new FormData($(this).parents('form').first().get(0));
    if ($.inArray(fileType, validImageTypes) < 0) {
      img_err.text('Please upload an image of jpg,jpeg,png,tif,gif format');
      setTimeout(function () {
        img_err.text('');
      }, 10000);
    } else if (file['size'] / 1024 / 1024 == 10) {
      img_err.text('Image size must be less than 10MB');
      setTimeout(function () {
        img_err.text('');
      }, 10000);
    } else {
      p_con.removeClass('d-none');
      current.attr('disabled', true);
      $.ajax({
        xhr: function xhr() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              p_bar.attr('aria-valuenow', percentComplete);
              p_bar.text(percentComplete + '%');
              p_bar.css('width', percentComplete + '%');
              p_bar.css('display', 'block');
            }
          }, false);
          return xhr;
        },
        url: url,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(result) {
          var img_path = result['img_path'];
          course_img.attr('src', img_path);
          p_con.addClass('d-none');
          current.attr('disabled', false);
        },
        error: function error(d) {
          p_bar.attr('aria-valuenow', 0);
          p_bar.text(0 + '%');
          p_bar.css('width', 0 + '%');
          p_con.addClass('d-none');
          current.attr('disabled', false);
          $('.upload_img').val(null);
          popup_message(d);
        }
      });
    }
  });
  $('.upload_vid').on('change', function () {
    var current_file = $(this);
    var c_f_form = current_file.parents('.course_vid').first();
    var form_data = new FormData(current_file.parents('form').first().get(0));
    var file = this.files[0];
    var file_err = $('.vid_err');
    var vid_p_con = $('.vid_p_con');
    var vid_p_bar = $('.vid_p_bar');
    var video_img = $('.video_img');
    if (file) {
      if (!file.type.startsWith("video")) {
        file_err.text('Only video files are allowed');
        current_file.addClass('is-invalid');
        setInterval(function () {
          file_err.text('');
          current_file.removeClass('is-invalid');
        }, 10000);
      } else if (parseInt(file.size / 1024 / 1024) > 4096) {
        file_err.text('File size cannot exceed from 4GB');
        current_file.addClass('is-invalid');
        setInterval(function () {
          file_err.text('');
          current_file.removeClass('is-invalid');
        }, 10000);
      } else {
        current_file.attr('disabled', true);
        var video_url = current_file.attr('url');
        vid_p_con.removeClass('d-none');
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
            xhr: function xhr() {
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  var c_progress = Math.round(percentComplete * 100);
                  vid_p_bar.attr('aria-valuenow', c_progress);
                  vid_p_bar.css('width', c_progress + '%');
                  vid_p_bar.html('<b> Uploading  ' + c_progress + '% </b>');
                }
              }, false);
              return xhr;
            },
            success: function success(data) {
              current_file.attr('disabled', false);
              vid_p_con.addClass('d-none');
              var video_path = data['video_path'];
              var video_type = data['video_type'];
              video_img.replaceWith("\n                                <video width=\"450\" height=\"350\" controls>\n                                    <source src=\"".concat(video_path, "\" type=\"").concat(video_type, "\">\n                                </video>\n                                "));
              location.reload();
            },
            error: function error(data) {
              current_file.attr('disabled', false);
              vid_p_con.addClass('d-none');
              vid_p_bar.attr('aria-valuenow', 0);
              vid_p_bar.css('width', 0 + '%');
              vid_p_bar.html('<b> Uploading  ' + 0 + '% </b>');
              if (typeof data == "json") {
                data = JSON.parse(data['responseText']);
                var course_vid = data['course_vid']['course_vid'];
                popup_message(course_vid);
              } else {
                popup_message(err_msg);
              }
              // reset already selected image
              $('.upload_vid').val(null);
            }
          });
        }
      }
    }
  });
});
/******/ })()
;