/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/admin_courses.js ***!
  \***************************************/
$(function () {
  $('#courses').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
  $('#sorting').change(function () {
    if ($(this).val() !== '') {
      $(this).parents('form').first().submit();
    }
  });
  $("#search_item").keypress(function () {
    if (event.which == 13 && $(this).val() !== '') {
      $(this).parents('form').first().submit();
    }
  });
  $('#update').click(function () {
    var status = $('#status').val();
    var url = $('#course_status_change').val();
    if (status !== "") {
      course_no = $('#courses_nos').val();
      if (course_no !== "") {
        $.ajax({
          type: 'post',
          url: url,
          dataType: 'json',
          data: {
            'course_no': course_no,
            'status': status
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function success(d) {
            show_message(d);
            location.reload();
          },
          error: function error(d) {
            errors = JSON.parse(d.responseText)['errors'];
            console.log(errors);
          }
        });
      } else {
        show_message("Please select a course");
      }
    } else {
      show_message('Please choose the status');
    }
  });
  $('.course_no').change(function () {
    var current_el = $(this);
    if (current_el.is(':checked')) {
      $('#courses_nos').val(current_el.attr('values'));
    }
  });
});
/******/ })()
;