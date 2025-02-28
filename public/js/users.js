/******/ (() => { // webpackBootstrap
/*!*******************************!*\
  !*** ./resources/js/users.js ***!
  \*******************************/
$(function () {
  $('#users').addClass('bg-website text-white').removeClass('text-dark font-weight-bold');
  $('.delete').click(function () {
    if (confirm('Do you want to delete this user? Deleting this user might cause some issue')) {
      var del = $(this);
      var url = del.attr('link');
      if (url) {
        $.ajax({
          url: url,
          type: 'delete',
          dateType: 'json',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function success(d) {
            show_message(d['status']);
            del.parents('.u_record').first().remove();
          }
        });
      }
    }
  });
  $('#sorting').change(function () {
    $(this).parents('form').first().submit();
  });
});
$("#search_item").keypress(function () {
  if (event.which == 13 && $(this).val() !== '') {
    $(this).parents('form').first().submit();
  }
});
/******/ })()
;