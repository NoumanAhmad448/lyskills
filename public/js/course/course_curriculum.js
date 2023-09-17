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
/******/ 	return __webpack_require__(__webpack_require__.s = 20);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/course/course_curriculum.js":
/*!**************************************************!*\
  !*** ./resources/js/course/course_curriculum.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('#add_sec, .add_material').tooltip();
  $('body').addClass('min-vh-100 d-flex flex-column');
  $('.footer').addClass('mt-auto');
  $(".sec-container").on("change", ".is_free", function () {
    url = $(this).attr("url");
    media_id = $(this).attr("media_id");
    set_free = $("#is_free_".concat(media_id)).is(":checked") ? 1 : 0;
    body_part = {
      set_free: set_free
    };
    body_part['set_download'] = $("#is_download_".concat(media_id)).is(":checked") ? 1 : 0;
    body = body_part;

    if (debug) {
      console.log(body);
    }

    $.ajax({
      url: url,
      type: "post",
      data: body,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json'
    }).done(function (e) {
      show_popup("Requested operation has been performed");
      $("#close-modal").removeAttr("onclick");
    }).fail(function () {
      console.error(err);
    });
  });
});

function cancel(event) {
  var current_elem = $(event.target);
  var prev_val = current_elem.attr('prev_val');
  var parent_form = $(current_elem.parents('form'));

  if (parent_form !== 'undefined') {
    parent_form.replaceWith("<div class=\"sec_title ml-md-2\">\n           ".concat(prev_val, "\n            <span class=\"sec_title_edit ml-2\" >\n                <i class=\"las la-pen\"></i>\n            </span>\n    </div>"));
  } else {
    console.error('could not find form element');
  }
}

function cancel_title(event) {
  var current_elem = $(event.target);
  var parent_form = $(current_elem.parents('form'));

  if (parent_form !== 'undefined') {
    parent_form.replaceWith("<div class=\"btn website add_title\">\n            <i class=\"las la-plus\"></i>\n            Add Title\n        </div>");
  } else {
    console.error('could not find form element');
  }
}

function reduceTextLen(input_txt) {
  var limit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 50;

  if (input_txt.length > limit) {
    return input_txt.substr(0, limit) + "...";
  }

  return input_txt;
}

$(function () {
  $("body").on("change", "#set_all_video", function () {
    url = $(this).attr("url");
    set_free = $(this).is(":checked") ? 1 : 0;
    body_part = {
      set_free: set_free
    };
    body = body_part;

    if (debug) {
      console.log(body);
    }

    $.ajax({
      url: url,
      type: "post",
      data: body,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json'
    }).done(function (e) {
      show_popup("Requested operation has been performed");
    }).fail(function () {
      console.error(err);
    });
  });
});

/***/ }),

/***/ 20:
/*!********************************************************!*\
  !*** multi ./resources/js/course/course_curriculum.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! B:\lyskills\resources\js\course\course_curriculum.js */"./resources/js/course/course_curriculum.js");


/***/ })

/******/ });