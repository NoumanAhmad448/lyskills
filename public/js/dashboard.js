/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/dashboard.js ***!
  \***********************************/
$(function () {
  $(".delete_course").click(function () {
    var get_id = $(this).attr('id');
    if (get_id) {
      $('.delete').attr('onClick', "$('.".concat(get_id, "').submit();"));
      $('#course_delete').modal('show');
    }
  });
});
/******/ })()
;