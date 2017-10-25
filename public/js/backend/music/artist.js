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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/backend/artist.js":
/***/ (function(module, exports) {

var app = new Vue({
  el: '#app',
  data: {
    /*
    * Index View
    */
    all: true,
    add: false,
    /*
    * Edit View
    */
    view: true,
    edit: false,
    albums: false,
    singles: false,
    tracks: false,
    /*
    * Show View
    */
    upload: false
  },

  methods: {
    toggleIndex: function toggleIndex() {
      this.all = !this.all;
      this.add = !this.add;
    },
    toggleView: function toggleView(tab) {
      this.view = tab == "view" ? true : false;
      this.edit = tab == "edit" ? true : false;
      this.albums = tab == "albums" ? true : false;
      this.singles = tab == "singles" ? true : false;
      this.tracks = tab == "tracks" ? true : false;
    }
  },
  computed: {
    isFormDirty: function isFormDirty() {
      var _this = this;

      return Object.keys(this.fields).some(function (key) {
        return _this.fields[key].dirty;
      });
    },
    isFormInvalid: function isFormInvalid() {
      var _this2 = this;

      return Object.keys(this.fields).some(function (key) {
        return _this2.fields[key].invalid;
      });
    }
  }
});

/***/ }),

/***/ 3:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/backend/artist.js");


/***/ })

/******/ });