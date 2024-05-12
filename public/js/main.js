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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(".option").click(function () {
  $('.next').attr('disabled', false);
});
$(function () {
  $('.loading-section').fadeOut().removeClass("loader");
  $('#loading').fadeOut();
  $(".show-dropdown, .categories_menu").mouseenter(function () {
    $(".categories_menu").show();
  });
  $(".show-dropdown, .categories_menu").mouseleave(function () {
    $(".categories_menu").hide();
  });
});
$(function () {
  var search = $("#search_course");

  if (search && search.length > 0) {
    search.autocomplete({
      source: function source(request, response) {
        $.ajax({
          url: "{{route('get-search')}}",
          type: "post",
          dataType: "json",
          headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
          },
          data: {
            q: request.term
          },
          success: function success(data) {
            response(data);
          }
        });
      },
      minLength: 2,
      select: function select(event, ui) {
        search.val(ui.item.label);
        search.parents('form').submit();
      }
    });
  }
});
$(function () {
  window.fbAsyncInit = function () {
    FB.init({
      xfbml: true,
      version: 'v9.0'
    });
  };

  (function (d, s, id) {
    var js,
        fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  })(document, 'script', 'facebook-jssdk');
});
$(function () {
  $("#close_user_notification").click(function () {
    localStorage.setItem("closed_user_notification", true);
  });
});

if (localStorage.getItem("closed_user_notification")) {
  $("#close_user_notification").click();
}

$(function () {
  $('#hamburger').click(function () {
    var side_menu = $('#side_menu');

    if (side_menu.hasClass('d-none')) {
      side_menu.removeClass('d-none');
    } else {
      side_menu.addClass('d-none');
    }
  });
  $('#a_setting').click(function () {
    var menu = $('.s_sub_menu');

    if (menu.hasClass('d-none')) {
      menu.removeClass('d-none');
    } else {
      menu.addClass('d-none');
    }
  });
  $('.loading-section').fadeOut().removeClass("loader");
  $('#loading').fadeOut();
  $('#sub_course').click(function () {
    var url = $(this).attr('link');

    if (url) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function success(result) {
          var res = result;

          if (res['status'] == 'success') {
            var body = $('#submitCourseModal').find('.modal-body');

            if (body.find('.msg').length === 0) {
              body.html("<h4 class=\"text-center my-3 msg\"> Congtratulation </h4><p class=\"text-justify\"> Your course has been submitted for review to lyskills. Now, Please wait for the\n                approval and once it finishes, you course will be available online and other students will be able to enroll </p>\n                <p class=\"text-justify text-danger\"> Due to huge number of daily requests, we take 24-72 hours to process your course so please wait for \n                our response </p>");
            }
          } else {
            var _body = $('#submitCourseModal').find('.modal-body');

            if (_body.find('.error').length === 0) {
              _body.html("<h4 class=\"text-center mt-3 error p-2 text-danger\"> Failed </h4><p>\n                we are sorry to inform you that, your course cannot be submitted because you did not provide us the following information.\n                Please complete all the remaining section and come back to this option again. Thanks\n                </p><ul class=\"list-group list-group-flush\">");

              var errs = "";

              for (index in res) {
                errs += "<li class=\"list-group-item\"> ".concat(res[index], " </li>");
              }

              errs += '</ul>';

              _body.append(errs);
            }
          }

          $('#submitCourseModal').modal('show');
        }
      });
    }
  });
});

/***/ }),

/***/ 6:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! B:\lyskills\resources\js\main.js */"./resources/js/main.js");


/***/ })

/******/ });