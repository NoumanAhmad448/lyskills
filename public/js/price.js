/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/price.js ***!
  \*******************************/
$(function () {
  $('#free').click(function () {
    if ($(this).prop('checked')) {
      $('.pricing').val('').attr('disabled', 'disabled');
      $("button[type='submit']").removeAttr('disabled');
    } else {
      $('.pricing').removeAttr('disabled').attr('required', 'required');
      $("button[type='submit']").prop('disabled', true);
    }
  });
  $('.pricing').keypress(function () {
    if (!$(this).val()) {
      $("button[type='submit']").prop('disabled', true);
    }
    $("button[type='submit']").removeAttr('disabled');
  });
  $('.p_price').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('url');
    var err = $('#pricing_err');
    var data = $(this).serialize();
    if (url) {
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(data) {
          show_message(data['status']);
        },
        error: function error(d) {
          if (typeof d == "json") {
            var errors = JSON.parse(d.responseText).errors;
            var pricing = errors['pricing'];
            if (pricing) {
              show_message(pricing);
            }
          } else {
            show_message(err_msg);
          }
        }
      });
    }
  });
  $('#pricing').removeClass('text-info').addClass('bg-website text-white');
});
/******/ })()
;