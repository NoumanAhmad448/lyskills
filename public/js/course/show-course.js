/******/ (() => { // webpackBootstrap
/*!********************************************!*\
  !*** ./resources/js/course/show-course.js ***!
  \********************************************/
$(function () {
  $('.rating').each(function (index) {
    if (index < rating) {
      $(this).addClass('text-warning');
    } else {
      $(this).removeClass('text-warning');
    }
  });
  // var video = $("#vid01")
  // console.log(video)
  // var file = new Blob(
  //     {"type" : "video\/mp4"});
  // var value = URL.createObjectURL(file);
  // video.src = value
  // video.load()

  // console.log(url)
  // var xhr = new XMLHttpRequest();
  // xhr.open('GET', video.attr("url"));
  // xhr.responseType = 'blob';
  // xhr.onload = function(e){
  //     var blob = new Blob(([xhr.response]))
  //     var url = URL.createObjectURL(blob)
  //     video.attr('src',url)
  // };
  // xhr.send()
});
$(".show_popup").click(function () {
  video_source = $("#video-source");
  if (video_source.length) {
    video_source.attr("src", $(this).attr("url"));
    // show loader
    $('.loading-section').addClass('loader').fadeIn();
    $('#loading').fadeIn();
    setTimeout(function () {
      // hide loader
      $('#loading', '.loading-section').fadeOut();
      $('.loading-section').removeClass('loader').fadeOut();
      $("#show-video").modal({
        keyboard: true,
        focus: true,
        show: true
      });
    }, 3000);
  }
});
$(function () {
  $('#share_course').click(function () {
    var url = $(this).attr('link');
    if (url) {
      $('#show_link').text(url);
      $('#course_share_modal').modal('show');
    }
  });
  $('#copy_url').click(function () {
    document.execCommand("copy");
    navigator.clipboard.writeText($('#show_link').text().trim());
    // $('#temp_field').remove();
    $('#show_msg').text('copied!');
    setTimeout(function () {
      $('#show_msg').text('');
    }, 10000);
  });
  $('#show_time').text($('#total_time').val());
  $('#show-video').on('hidden.bs.modal', function (e) {
    $("#video-source").attr("src", "");
  });
});
/******/ })()
;