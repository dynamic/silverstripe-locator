webpackJsonp([0],{

/***/ 124:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__SearchBar__ = __webpack_require__(146);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__Map__ = __webpack_require__(145);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }






var Locator = function (_React$Component) {
  _inherits(Locator, _React$Component);

  function Locator() {
    _classCallCheck(this, Locator);

    return _possibleConstructorReturn(this, (Locator.__proto__ || Object.getPrototypeOf(Locator)).apply(this, arguments));
  }

  _createClass(Locator, [{
    key: 'render',
    value: function render() {
      console.log(this.props);
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        null,
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_1__SearchBar__["a" /* default */], null),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_2__Map__["a" /* default */], null)
      );
    }
  }]);

  return Locator;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

/* harmony default export */ __webpack_exports__["a"] = (Locator);

/***/ }),

/***/ 125:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = reducers;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_redux__ = __webpack_require__(33);


function reducers(client) {
  return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_redux__["combineReducers"])({
    client: client.reducer()
  });
}

/***/ }),

/***/ 143:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(127);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_redux__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_redux_thunk__ = __webpack_require__(128);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_redux_thunk___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_redux_thunk__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_apollo_client__ = __webpack_require__(71);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_react_apollo__ = __webpack_require__(126);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_react_apollo___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_react_apollo__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_reducers__ = __webpack_require__(125);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_components_Locator__ = __webpack_require__(124);













var container = document.querySelector('.locator');

var client = new __WEBPACK_IMPORTED_MODULE_4_apollo_client__["default"]({
  networkInterface: __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_4_apollo_client__["createNetworkInterface"])({
    uri: container.dataset.apiUrl,
    opts: {
      credentials: 'same-origin'
    }
  }),
  reduxRootSelector: function reduxRootSelector(state) {
    return state.client;
  }
});

function composedMiddleware() {
  return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_redux__["compose"])(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_redux__["applyMiddleware"])(client.middleware(), __WEBPACK_IMPORTED_MODULE_3_redux_thunk___default.a), typeof window.__REDUX_DEVTOOLS_EXTENSION__ !== 'undefined' ? window.__REDUX_DEVTOOLS_EXTENSION__() : function (f) {
    return f;
  });
}

var store = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_redux__["createStore"])(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_6_reducers__["a" /* default */])(client), composedMiddleware());

__WEBPACK_IMPORTED_MODULE_1_react_dom___default.a.render(__WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
  __WEBPACK_IMPORTED_MODULE_5_react_apollo__["ApolloProvider"],
  { store: store, client: client },
  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_7_components_Locator__["a" /* default */], null)
), container);

/***/ }),

/***/ 144:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var Location = function (_React$Component) {
  _inherits(Location, _React$Component);

  function Location() {
    _classCallCheck(this, Location);

    return _possibleConstructorReturn(this, (Location.__proto__ || Object.getPrototypeOf(Location)).apply(this, arguments));
  }

  _createClass(Location, [{
    key: "render",
    value: function render() {
      var loc = this.props;
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        "li",
        { "data-markerid": "0" },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "div",
          { className: "list-label" },
          "1"
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "div",
          { className: "list-details" },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            "div",
            { className: "list-content" },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "div",
              { className: "loc-name" },
              "Location Name"
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "div",
              { className: "loc-addr" },
              "Address"
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "div",
              { className: "loc-addr3" },
              "City, State Zip"
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "div",
              { className: "loc-dist" },
              "Distance\xA0|\xA0",
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                "a",
                { href: "#", target: "_blank" },
                "Link"
              )
            )
          )
        )
      );
    }
  }]);

  return Location;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

/* harmony default export */ __webpack_exports__["a"] = (Location);

/***/ }),

/***/ 145:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__Location__ = __webpack_require__(144);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var Map = function (_React$Component) {
  _inherits(Map, _React$Component);

  function Map() {
    _classCallCheck(this, Map);

    return _possibleConstructorReturn(this, (Map.__proto__ || Object.getPrototypeOf(Map)).apply(this, arguments));
  }

  _createClass(Map, [{
    key: 'renderLocations',
    value: function renderLocations() {
      if (this.props.locations !== undefined) {
        return this.props.locations.map(function (radius) {
          return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_1__Location__["a" /* default */], null);
        });
      }
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_1__Location__["a" /* default */], null);
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        { id: 'map-container' },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { id: 'map' }),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'loc-list' },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'ul',
            null,
            this.renderLocations()
          )
        )
      );
    }
  }]);

  return Map;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

/* harmony default export */ __webpack_exports__["a"] = (Map);

/***/ }),

/***/ 146:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }



var SearchBar = function (_React$Component) {
  _inherits(SearchBar, _React$Component);

  function SearchBar() {
    _classCallCheck(this, SearchBar);

    return _possibleConstructorReturn(this, (SearchBar.__proto__ || Object.getPrototypeOf(SearchBar)).apply(this, arguments));
  }

  _createClass(SearchBar, [{
    key: "mappedRadii",
    value: function mappedRadii() {
      return this.props.radii.map(function (radius) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "option",
          { value: "radius" },
          "radius"
        );
      });
    }
  }, {
    key: "radius",
    value: function radius() {
      if (this.props.radii !== undefined) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "div",
          { className: "field dropdown form-group--no-label" },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            "div",
            { className: "middleColumn" },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "select",
              { name: "Radius", className: "dropdown form-group--no-label" },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                "option",
                { value: "", selected: "selected" },
                "radius"
              ),
              this.mappedRadii()
            )
          )
        );
      } else {
        return null;
      }
    }
  }, {
    key: "render",
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        "form",
        null,
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "fieldset",
          null,
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            "div",
            { className: "field text form-group--no-label" },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              "div",
              { className: "middleColumn" },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("input", {
                type: "text",
                name: "adress",
                className: "text form-group--no-label",
                required: "required",
                "aria-required": "true",
                placeholder: "address or zip code"
              })
            )
          ),
          this.radius(),
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("div", { className: "clear" })
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          "div",
          { className: "btn-toolbar" },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement("input", {
            type: "submit",
            name: "action_doFilterLocations",
            value: "Search",
            className: "action"
          })
        )
      );
    }
  }]);

  return SearchBar;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

/* harmony default export */ __webpack_exports__["a"] = (SearchBar);

/***/ })

},[143]);
//# sourceMappingURL=main.js.map