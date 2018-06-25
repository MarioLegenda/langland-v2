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
/******/ 	__webpack_require__.p = "/public/dist/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./frontend/index.ts");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./frontend/index.ts":
/*!***************************!*\
  !*** ./frontend/index.ts ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\nvar deck = {\n    suits: [\"hearts\", \"spades\", \"clubs\", \"diamonds\"],\n    cards: Array(52),\n    createCardPicker: function () {\n        var _this = this;\n        // NOTE: the line below is now an arrow function, allowing us to capture 'this' right here\n        return function () {\n            var pickedCard = Math.floor(Math.random() * 52);\n            var pickedSuit = Math.floor(pickedCard / 13);\n            return { suit: _this.suits[pickedSuit], card: pickedCard % 13 };\n        };\n    }\n};\nvar cardPicker = deck.createCardPicker();\nvar pickedCard = cardPicker();\nalert(\"card: \" + pickedCard.card + \" of \" + pickedCard.suit);\n\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9mcm9udGVuZC9pbmRleC50cz8zMjI5Il0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7QUFBQSxJQUFJLElBQUksR0FBRztJQUNQLEtBQUssRUFBRSxDQUFDLFFBQVEsRUFBRSxRQUFRLEVBQUUsT0FBTyxFQUFFLFVBQVUsQ0FBQztJQUNoRCxLQUFLLEVBQUUsS0FBSyxDQUFDLEVBQUUsQ0FBQztJQUNoQixnQkFBZ0IsRUFBRTtRQUFBLGlCQVFqQjtRQVBHLDBGQUEwRjtRQUMxRixPQUFPO1lBQ0gsSUFBSSxVQUFVLEdBQUcsSUFBSSxDQUFDLEtBQUssQ0FBQyxJQUFJLENBQUMsTUFBTSxFQUFFLEdBQUcsRUFBRSxDQUFDLENBQUM7WUFDaEQsSUFBSSxVQUFVLEdBQUcsSUFBSSxDQUFDLEtBQUssQ0FBQyxVQUFVLEdBQUcsRUFBRSxDQUFDLENBQUM7WUFFN0MsT0FBTyxFQUFDLElBQUksRUFBRSxLQUFJLENBQUMsS0FBSyxDQUFDLFVBQVUsQ0FBQyxFQUFFLElBQUksRUFBRSxVQUFVLEdBQUcsRUFBRSxFQUFDLENBQUM7UUFDakUsQ0FBQztJQUNMLENBQUM7Q0FDSjtBQUVELElBQUksVUFBVSxHQUFHLElBQUksQ0FBQyxnQkFBZ0IsRUFBRSxDQUFDO0FBQ3pDLElBQUksVUFBVSxHQUFHLFVBQVUsRUFBRSxDQUFDO0FBRTlCLEtBQUssQ0FBQyxRQUFRLEdBQUcsVUFBVSxDQUFDLElBQUksR0FBRyxNQUFNLEdBQUcsVUFBVSxDQUFDLElBQUksQ0FBQyxDQUFDIiwiZmlsZSI6Ii4vZnJvbnRlbmQvaW5kZXgudHMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJsZXQgZGVjayA9IHtcbiAgICBzdWl0czogW1wiaGVhcnRzXCIsIFwic3BhZGVzXCIsIFwiY2x1YnNcIiwgXCJkaWFtb25kc1wiXSxcbiAgICBjYXJkczogQXJyYXkoNTIpLFxuICAgIGNyZWF0ZUNhcmRQaWNrZXI6IGZ1bmN0aW9uKCkge1xuICAgICAgICAvLyBOT1RFOiB0aGUgbGluZSBiZWxvdyBpcyBub3cgYW4gYXJyb3cgZnVuY3Rpb24sIGFsbG93aW5nIHVzIHRvIGNhcHR1cmUgJ3RoaXMnIHJpZ2h0IGhlcmVcbiAgICAgICAgcmV0dXJuICgpID0+IHtcbiAgICAgICAgICAgIGxldCBwaWNrZWRDYXJkID0gTWF0aC5mbG9vcihNYXRoLnJhbmRvbSgpICogNTIpO1xuICAgICAgICAgICAgbGV0IHBpY2tlZFN1aXQgPSBNYXRoLmZsb29yKHBpY2tlZENhcmQgLyAxMyk7XG5cbiAgICAgICAgICAgIHJldHVybiB7c3VpdDogdGhpcy5zdWl0c1twaWNrZWRTdWl0XSwgY2FyZDogcGlja2VkQ2FyZCAlIDEzfTtcbiAgICAgICAgfVxuICAgIH1cbn1cblxubGV0IGNhcmRQaWNrZXIgPSBkZWNrLmNyZWF0ZUNhcmRQaWNrZXIoKTtcbmxldCBwaWNrZWRDYXJkID0gY2FyZFBpY2tlcigpO1xuXG5hbGVydChcImNhcmQ6IFwiICsgcGlja2VkQ2FyZC5jYXJkICsgXCIgb2YgXCIgKyBwaWNrZWRDYXJkLnN1aXQpOyJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./frontend/index.ts\n");

/***/ })

/******/ });