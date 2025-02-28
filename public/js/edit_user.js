/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/edit_user.js ***!
  \***********************************/
$(function () {
  $('#name , #email, #student, #instructor').click(function () {
    $(this).removeClass('is-invalid');
  });
  $(".alert").delay(5000).slideUp(300);
});
/******/ })()
;