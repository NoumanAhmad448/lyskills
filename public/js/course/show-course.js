/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 19);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/course/show-course.js":
/*!********************************************!*\
  !*** ./resources/js/course/show-course.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('.rating').each(function (index) {
    if (index < rating) {
      $(this).addClass('text-warning');
    } else {
      $(this).removeClass('text-warning');
    }
  }); // var video = $("#vid01")
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
    video_source.attr("src", $(this).attr("url")); // show loader

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
    navigator.clipboard.writeText($('#show_link').text().trim()); // $('#temp_field').remove();

    $('#show_msg').text('copied!');
    setTimeout(function () {
      $('#show_msg').text('');
    }, 10000);
  });
  $('#show_time').text($('#total_time').val());
});

/***/ }),

/***/ 19:
/*!**************************************************!*\
  !*** multi ./resources/js/course/show-course.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! B:\lyskills\resources\js\course\show-course.js */"./resources/js/course/show-course.js");


/***/ })

/******/ });