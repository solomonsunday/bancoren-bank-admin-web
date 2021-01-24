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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/utility.js":
/*!*********************************!*\
  !*** ./resources/js/utility.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

(function ($) {
  "use strict";
});

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

window.getFormAsJsonData = function (form_element) {
  var data = {};
  $.map($("".concat(form_element, " input[type=\"text\"],").concat(form_element, " select,\n            ").concat(form_element, " input[type=\"number\"],").concat(form_element, " input[type=\"password\"],\n            ").concat(form_element, " input[type=\"radio\"]:checked, ").concat(form_element, " textarea, ").concat(form_element, " input[type=\"date\"], ").concat(form_element, " input[type=\"date\"] , ").concat(form_element, " input[type=\"email\"]")), function (elem, idx) {
    if ($(elem).attr("type") === "radio") {
      var name = $(elem).attr("name");
      data = _objectSpread(_objectSpread({}, data), {}, _defineProperty({}, name, $("input[type=radio][name=".concat(name, "]:checked")).val()));
    } else {
      data = _objectSpread(_objectSpread({}, data), {}, _defineProperty({}, $(elem).attr("id"), $(elem).val()));
    }
  });
  return data;
};

window.getFormAsFormData = function (form_element) {
  var formData = new FormData();
  $.map($("".concat(form_element, " input,").concat(form_element, " select, ").concat(form_element, " textarea")), function (elem, idx) {
    if ($(elem).attr("type") === "file") {
      formData.append($(elem).attr("id"), $(elem)[0].files[0]);
    } else {
      formData.append($(elem).attr("id"), $(elem).val());
    }
  });
  return formData;
};

window.redirectTo = function (loginUrl) {
  var timeout = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  if (timeout === true) {
    setTimeout(function () {
      window.location.href = loginUrl;
    }, 1000);
  } else {
    window.location.href = loginUrl;
  }
};

window.toggleFullPageLoader = function (show, htmldata) {
  if (show !== undefined) {
    if (show === true) {
      $('.login-btn').attr('disabled', true);
      $('.d-none').css("display", '');
      $('#msg').html('');
      $('#msg').append('loading...');
    } else {
      $('.d-none').css("display", 'none');
      $('#msg').html('');
      $('#msg').append(htmldata);
      $('.login-btn').attr('disabled', false);
    }
  } else {
    $('.d-none').css("display", 'none');
    $('#msg').html('');
    $('#msg').append(htmldata); // $('#full-loader').toggleClass("d-none");
  }
};

window.conditionalAlertfire = function (_ref) {
  var title = _ref.title,
      icon = _ref.icon,
      text = _ref.text,
      action_url = _ref.action_url,
      method = _ref.method,
      proof = _ref.proof,
      table_id = _ref.table_id,
      proof2 = _ref.proof2;
  Swal.fire({
    icon: icon !== null && icon !== void 0 ? icon : "info",
    title: title,
    text: text,
    button: {
      text: "Close",
      value: true,
      visible: true,
      className: "btn btn-alert-btn"
    },
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: "Yes ".concat(proof, " it")
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        url: action_url,
        type: method,
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
          toggleFullPageLoader(true);
        },
        success: function success(data, status, xhr) {
          fireAlert({
            title: "Success",
            text: "".concat(proof2, " successfully")
          });
          $("#".concat(table_id)).DataTable().ajax.reload();
        },
        error: function error(jqXhr, textStatus, errorMessage) {
          var data = jqXhr.responseJSON;
          var errors = data.errors || data.message || data.data || data;

          if (jqXhr.status == 401) {
            redirectTo('../');
          }

          fireAlert({
            icon: "error",
            title: "Request Failed!",
            text: errors
          }); //  if (typeof errors === "object") {
          //      Object.keys(errors.data).forEach(function(key){
          //          let selector = $(`#${key}-error-msg`);
          //          selector.html(errors[key][0]);
          //          $(`#${key}`).parent('.form-group').removeClass("has-danger");
          //          selector.fadeIn();
          //      });
          //  } else {
          //  }
        },
        complete: function complete() {
          toggleFullPageLoader(false);
        }
      });
    }
  });
};

window.fireAlert = function (_ref2) {
  var title = _ref2.title,
      icon = _ref2.icon,
      text = _ref2.text,
      html = _ref2.html;
  Swal.fire({
    icon: icon !== null && icon !== void 0 ? icon : "success",
    title: title,
    text: text,
    html: html,
    button: {
      text: "Close",
      value: true,
      visible: true,
      className: "btn btn-alert-btn"
    }
  });
};

$('input.monitor').change(function () {
  $(this).parent('.form-group').removeClass("has-danger");
  var id_attr = ($(this).attr("id") || "").toLowerCase();
  $("#".concat(id_attr, "-error-msg")).html("");
});

/***/ }),

/***/ 0:
/*!***************************************!*\
  !*** multi ./resources/js/utility.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/itexecutive/Documents/bancoren-v2-admin/resources/js/utility.js */"./resources/js/utility.js");


/***/ })

/******/ });