/******/ (() => { // webpackBootstrap
/*!******************************************!*\
  !*** ./resources/js/common_functions.js ***!
  \******************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
window.show_popup = function (message) {
  $("#modal-body").html(message);
  $("#pop-message").modal({
    keyboard: true,
    focus: true,
    show: true
  });
};
window.show_message = function () {
  var text = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "your message";
  var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "Info";
  var icon = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "info";
  var button = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "ok";
  swal({
    title: title,
    text: text,
    icon: icon,
    button: button
  });
};
window.popup_message = function (d) {
  if (debug) {
    console.error(d);
    console.error(_typeof(d));
  }
  if (Array.isArray(d)) {
    show_message(text = d[0]);
  } else if (_typeof(d) === "object") {
    show_message(text = err_msg);
  } else if (typeof d === "json") {
    var d = JSON.parse(d.responseText).errors;
    if (typeof d == "string") {
      show_message(text = d);
    } else if (Array.isArray(d) && d.length > 1) {
      show_message(text = d[0]);
    } else if (_typeof(d) == "object") {
      if (d["course_img"]) {
        if (Array.isArray(d["course_img"])) {
          show_message(text = d["course_img"][0]);
        } else if (typeof d == "string") {
          show_message(text = d["course_img"]);
        }
      }
    }
  } else if (typeof d === "string") {
    show_message(text = d);
  }
};
/******/ })()
;