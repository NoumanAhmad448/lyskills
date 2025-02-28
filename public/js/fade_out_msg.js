/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/fade_out_msg.js ***!
  \**************************************/
$(function () {
  setTimeout(function () {
    var msg = $('.alert');
    if (msg) {
      msg.fadeOut();
    }
  }, 5000);
});
/******/ })()
;