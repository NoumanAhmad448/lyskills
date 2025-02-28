/******/ (() => { // webpackBootstrap
/*!**************************************!*\
  !*** ./resources/js/course_title.js ***!
  \**************************************/
$("#title_box").keyup(function () {
  // show_message('working');

  var text_len = $(this).val().length;
  var title = $('#title');
  var count_char = $('.count_char').text();
  // console.log(count_char);

  if (count_char <= text_len && title.text() <= 60) {
    $('.next').attr('disabled', false);
    var char_len = title.text();
    if (char_len < 0) {
      char_len.text(0);
    } else {
      title.text(parseInt(char_len) - 1);
    }
  } else if (text_len == 0) {
    $('.next').attr('disabled', true);
    title.text(60);
  } else {
    var char_len = title.text();
    if (char_len > 60) {
      char_len.text(60);
    } else {
      title.text(parseInt(char_len) + 1);
    }
  }
  $('.count_char').text(text_len);
});
$title = $('#title');
$title.text($title.text() - $('#title_box').val().length);
/******/ })()
;