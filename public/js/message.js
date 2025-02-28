/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/message.js ***!
  \*********************************/
$(function () {
  $('#msg').removeClass('text-info').addClass('bg-website text-white');
  $('.final_form').submit(function (e) {
    e.preventDefault();
    var c = $(this);
    var url = c.attr('url');
    var data = c.serialize();
    var wel_err = $('#wel_err');
    var congo_err = $('#congo_err');
    var success_msg = $('.success_msg');
    if (url) {
      $.ajax({
        data: data,
        url: url,
        type: 'post',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(d) {
          success_msg.text(d['status']);
          setTimeout(function () {
            success_msg.text('');
          }, 10000);
        },
        error: function error(d) {
          var err = JSON.parse(d.responseText).errors;
          var wel_msg = err['wel_msg'];
          var congo_msg = err['congo_msg'];
          if (wel_msg) {
            wel_err.text(wel_msg[0]);
          }
          if (congo_msg) {
            congo_err.text(congo_msg);
          }
          setTimeout(function () {
            wel_err.text('');
            congo_err.text('');
          }, 10000);
        },
        dataType: 'json'
      });
    }
  });
});
/******/ })()
;