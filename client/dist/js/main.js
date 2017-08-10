webpackJsonp([0],{

/***/ 259:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_apollo__ = __webpack_require__(151);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_apollo___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_react_apollo__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_react_redux__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_react_redux___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_react_redux__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_queries_readLocations__ = __webpack_require__(282);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_components_search_SearchBar__ = __webpack_require__(281);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_components_map_MapArea__ = __webpack_require__(609);
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
      var radii = [25, 50, 75, 100];
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        null,
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_5_components_search_SearchBar__["a" /* default */], { radii: radii }),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_6_components_map_MapArea__["a" /* default */], { locations: this.props.data.readLocations })
      );
    }
  }]);

  return Locator;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

Locator.propTypes = {
  data: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.shape({
    readLocations: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.object
  }).isRequired
};

function mapStateToProps(state) {
  return {
    address: state.search.address,
    radius: state.search.radius
  };
}

/* harmony default export */ __webpack_exports__["a"] = (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_react_apollo__["compose"])(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3_react_redux__["connect"])(mapStateToProps), __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_react_apollo__["graphql"])(__WEBPACK_IMPORTED_MODULE_4_queries_readLocations__["a" /* default */], {
  options: function options(_ref) {
    var address = _ref.address,
        radius = _ref.radius;
    return {
      variables: {
        address: address,
        radius: radius
      }
    };
  }
}))(Locator));

/***/ }),

/***/ 260:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = reducers;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_redux__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_reducers_searchReducer__ = __webpack_require__(283);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_reducers_mapReducer__ = __webpack_require__(607);





function reducers(client) {
  return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0_redux__["combineReducers"])({
    client: client.reducer(),
    search: __WEBPACK_IMPORTED_MODULE_1_reducers_searchReducer__["a" /* default */],
    map: __WEBPACK_IMPORTED_MODULE_2_reducers_mapReducer__["a" /* default */]
  });
}

/***/ }),

/***/ 276:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = search;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__ = __webpack_require__(99);


function search(inputs) {
  return {
    type: __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__["a" /* default */].SEARCH,
    payload: inputs
  };
}

/***/ }),

/***/ 277:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom__ = __webpack_require__(92);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_dom___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_dom__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_redux__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_redux_thunk__ = __webpack_require__(261);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_redux_thunk___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_redux_thunk__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_apollo_client__ = __webpack_require__(150);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_react_apollo__ = __webpack_require__(151);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_react_apollo___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_react_apollo__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_reducers__ = __webpack_require__(260);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_components_Locator__ = __webpack_require__(259);













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

/***/ 280:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var RadiusDropDown = function (_React$Component) {
  _inherits(RadiusDropDown, _React$Component);

  function RadiusDropDown() {
    _classCallCheck(this, RadiusDropDown);

    return _possibleConstructorReturn(this, (RadiusDropDown.__proto__ || Object.getPrototypeOf(RadiusDropDown)).apply(this, arguments));
  }

  _createClass(RadiusDropDown, [{
    key: 'mappedRadii',
    value: function mappedRadii() {
      return this.props.radii.map(function (radius) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'option',
          {
            value: radius,
            key: radius
          },
          radius
        );
      });
    }
  }, {
    key: 'render',
    value: function render() {
      var radii = this.props.radii;

      if (radii !== undefined && radii.length > 0) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'field dropdown form-group--no-label' },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'div',
            { className: 'middleColumn' },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'select',
              {
                name: 'radius',
                className: 'dropdown form-group--no-label',
                defaultValue: ''
              },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                'option',
                { value: '' },
                'radius'
              ),
              this.mappedRadii()
            )
          )
        );
      } else {
        return null;
      }
    }
  }]);

  return RadiusDropDown;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

RadiusDropDown.propTypes = {
  radii: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.array.isRequired
};

/* harmony default export */ __webpack_exports__["a"] = (RadiusDropDown);

/***/ }),

/***/ 281:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_react_redux__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_actions_searchActions__ = __webpack_require__(276);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_components_search_RadiusDropDown__ = __webpack_require__(280);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var SearchBar = function (_React$Component) {
  _inherits(SearchBar, _React$Component);

  function SearchBar(props) {
    _classCallCheck(this, SearchBar);

    var _this = _possibleConstructorReturn(this, (SearchBar.__proto__ || Object.getPrototypeOf(SearchBar)).call(this, props));

    _this.handleSubmit = _this.handleSubmit.bind(_this);
    return _this;
  }

  _createClass(SearchBar, [{
    key: 'handleSubmit',
    value: function handleSubmit(event) {
      event.preventDefault();
      var addressInput = document.getElementsByName('address')[0].value;
      var radiusInput = document.getElementsByName('radius')[0].value;

      this.props.dispatch(__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_3_actions_searchActions__["a" /* search */])({
        address: addressInput,
        radius: radiusInput
      }));
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'form',
        { action: '', onSubmit: this.handleSubmit },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'fieldset',
          null,
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'div',
            { className: 'field text form-group--no-label' },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'div',
              { className: 'middleColumn' },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('input', {
                type: 'text',
                name: 'address',
                className: 'text form-group--no-label',
                required: 'required',
                'aria-required': 'true',
                placeholder: 'address or zip code'
              })
            )
          ),
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_4_components_search_RadiusDropDown__["a" /* default */], { radii: this.props.radii })
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'btn-toolbar' },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('input', {
            type: 'submit',
            value: 'Search',
            className: 'action'
          })
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { className: 'clear' })
      );
    }
  }]);

  return SearchBar;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

SearchBar.propTypes = {
  radii: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.array.isRequired,
  dispatch: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.func.isRequired
};

/* harmony default export */ __webpack_exports__["a"] = (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_react_redux__["connect"])()(SearchBar));

/***/ }),

/***/ 282:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_graphql_tag__ = __webpack_require__(177);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_graphql_tag___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_graphql_tag__);
var _templateObject = _taggedTemplateLiteral(['\n  query($address: String, $radius: String){\n    readLocations(address: $address, radius: $radius) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n        }\n      } \n    }\n  }\n'], ['\n  query($address: String, $radius: String){\n    readLocations(address: $address, radius: $radius) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n        }\n      } \n    }\n  }\n']);

function _taggedTemplateLiteral(strings, raw) { return Object.freeze(Object.defineProperties(strings, { raw: { value: Object.freeze(raw) } })); }



/* harmony default export */ __webpack_exports__["a"] = (__WEBPACK_IMPORTED_MODULE_0_graphql_tag___default()(_templateObject));

/***/ }),

/***/ 283:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = reducer;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__ = __webpack_require__(99);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };



var defaultState = {
  address: '',
  radius: ''
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__["a" /* default */].SEARCH:
      return _extends({}, state, {
        address: action.payload.address,
        radius: action.payload.radius
      });

    default:
      return state;
  }
}

/***/ }),

/***/ 607:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = reducer;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__ = __webpack_require__(99);
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };



var defaultState = {
  current: '-1',
  showCurrent: false
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__["a" /* default */].MARKER_CLICK:
      return _extends({}, state, {
        current: action.payload.key,
        showCurrent: true
      });

    case __WEBPACK_IMPORTED_MODULE_0_actions_ActionTypes__["a" /* default */].MARKER_CLOSE:
      return _extends({}, state, {
        showCurrent: false
      });

    default:
      return state;
  }
}

/***/ }),

/***/ 608:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
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
    key: 'addressThree',
    value: function addressThree() {
      var _props$location = this.props.location,
          City = _props$location.City,
          State = _props$location.State,
          PostalCode = _props$location.PostalCode;

      if (City !== null && State !== null && PostalCode !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'loc-addr3' },
          City,
          ', ',
          State,
          ' ',
          PostalCode
        );
      } else if (City === null && State !== null && PostalCode !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'loc-addr3' },
          State,
          ' ',
          PostalCode
        );
      } else if (City !== null && State === null && PostalCode !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'loc-addr3' },
          City,
          ' ',
          PostalCode
        );
      }
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { className: 'loc-addr3' });
    }
  }, {
    key: 'links',
    value: function links() {
      var _props$location2 = this.props.location,
          Website = _props$location2.Website,
          Phone = _props$location2.Phone;

      if (Website !== null && Phone !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          null,
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'a',
            { href: Website, target: '_blank' },
            'website'
          ),
          '\xA0|\xA0',
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'a',
            { href: 'tel:' + Phone },
            'phone'
          )
        );
      } else if (Website !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          null,
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'a',
            { href: Website, target: '_blank' },
            'website'
          )
        );
      } else if (Phone !== null) {
        return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          null,
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'a',
            { href: 'tel:' + Phone },
            'phone'
          )
        );
      }
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', null);
    }
  }, {
    key: 'render',
    value: function render() {
      var _props = this.props,
          location = _props.location,
          index = _props.index,
          current = _props.current;

      var className = '';
      if (current === location.ID) {
        className = 'focus';
      }
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'li',
        { 'data-markerid': index, className: className },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'list-label' },
          index + 1
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          'div',
          { className: 'list-details' },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'div',
            { className: 'list-content' },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'div',
              { className: 'loc-name' },
              location.Title
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'div',
              { className: 'loc-addr' },
              location.Address
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'div',
              { className: 'loc-addr2' },
              location.Address2
            ),
            this.addressThree(),
            this.links(),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'div',
              { className: 'loc-dist' },
              'Distance'
            )
          )
        )
      );
    }
  }]);

  return Location;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

Location.propTypes = {
  location: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.shape({
    Title: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    Address: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    Address2: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    City: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    State: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    PostalCode: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    Website: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
    Phone: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string
  }).isRequired,
  index: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.number.isRequired,
  current: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string.isRequired
};

/* harmony default export */ __webpack_exports__["a"] = (Location);

/***/ }),

/***/ 609:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_react_redux__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_components_map_Location__ = __webpack_require__(608);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_components_map_MapContainer__ = __webpack_require__(611);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var MapArea = function (_React$Component) {
  _inherits(MapArea, _React$Component);

  function MapArea() {
    _classCallCheck(this, MapArea);

    return _possibleConstructorReturn(this, (MapArea.__proto__ || Object.getPrototypeOf(MapArea)).apply(this, arguments));
  }

  _createClass(MapArea, [{
    key: 'renderLocations',
    value: function renderLocations() {
      var _this2 = this;

      var locs = this.props.locations.edges;
      if (locs !== undefined) {
        return locs.map(function (location, index) {
          return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_3_components_map_Location__["a" /* default */], {
            key: location.node.ID,
            index: index,
            location: location.node,
            current: _this2.props.current
          });
        });
      }
      return null;
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        { className: 'map-area' },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_4_components_map_MapContainer__["a" /* default */], { locations: this.props.locations }),
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

  return MapArea;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

MapArea.propTypes = {
  locations: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.shape({
    edges: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.array
  }),
  current: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string
};

MapArea.defaultProps = {
  locations: {
    edges: []
  },
  current: '-1'
};

function mapStateToProps(state) {
  return {
    current: state.map.current
  };
}

/* harmony default export */ __webpack_exports__["a"] = (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_react_redux__["connect"])(mapStateToProps)(MapArea));

/***/ }),

/***/ 610:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_google_maps__ = __webpack_require__(580);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_react_google_maps___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_react_google_maps__);



var Map = __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_react_google_maps__["withGoogleMap"])(function (props) {
  return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
    __WEBPACK_IMPORTED_MODULE_1_react_google_maps__["GoogleMap"],
    {
      defaultZoom: 9,
      defaultCenter: { lat: 43.8483258, lng: -87.7709294 }
    },
    props.markers.map(function (marker) {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        __WEBPACK_IMPORTED_MODULE_1_react_google_maps__["Marker"],
        {
          key: marker.key,
          position: marker.position,
          defaultAnimation: marker.defaultAnimation,
          onClick: function onClick() {
            return props.onMarkerClick(marker);
          }
        },
        props.current === marker.key && props.showCurrent && __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          __WEBPACK_IMPORTED_MODULE_1_react_google_maps__["InfoWindow"],
          { onCloseClick: function onCloseClick() {
              return props.onMarkerClose(marker);
            } },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'div',
            null,
            marker.infoContent
          )
        )
      );
    })
  );
});

/* harmony default export */ __webpack_exports__["a"] = (Map);

/***/ }),

/***/ 611:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux__ = __webpack_require__(147);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_redux___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_react_redux__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_actions_ActionTypes__ = __webpack_require__(99);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_components_map_Map__ = __webpack_require__(610);
var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }








var MapContainer = function (_React$Component) {
  _inherits(MapContainer, _React$Component);

  function MapContainer(props) {
    _classCallCheck(this, MapContainer);

    var _this = _possibleConstructorReturn(this, (MapContainer.__proto__ || Object.getPrototypeOf(MapContainer)).call(this, props));

    _this.handleMarkerClick = _this.handleMarkerClick.bind(_this);
    _this.handleMarkerClose = _this.handleMarkerClose.bind(_this);
    return _this;
  }

  _createClass(MapContainer, [{
    key: 'getMarkers',
    value: function getMarkers() {
      var locations = this.props.locations.edges;
      var markers = [];

      var i = void 0;

      for (i = 0; i < locations.length; i++) {
        var loc = locations[i].node;
        markers[markers.length] = {
          position: {
            lat: Number(loc.Lat),
            lng: Number(loc.Lng)
          },
          key: loc.ID,
          defaultAnimation: 2
        };
      }
      return markers;
    }
  }, {
    key: 'handleMarkerClick',
    value: function handleMarkerClick(target) {
      this.props.dispatch({
        type: __WEBPACK_IMPORTED_MODULE_3_actions_ActionTypes__["a" /* default */].MARKER_CLICK,
        payload: target
      });
    }
  }, {
    key: 'handleMarkerClose',
    value: function handleMarkerClose(target) {
      this.props.dispatch({
        type: __WEBPACK_IMPORTED_MODULE_3_actions_ActionTypes__["a" /* default */].MARKER_CLOSE,
        payload: target
      });
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        { id: 'map-container' },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_4_components_map_Map__["a" /* default */], {
          containerElement: __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { className: 'map' }),
          mapElement: __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { style: { height: '100%' } }),
          markers: this.getMarkers(),
          onMarkerClick: this.handleMarkerClick,
          onMarkerClose: this.handleMarkerClose,
          current: this.props.current,
          showCurrent: this.props.showCurrent
        })
      );
    }
  }]);

  return MapContainer;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

MapContainer.propTypes = {
  locations: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.shape({
    edges: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.array
  }),
  dispatch: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.func.isRequired,
  current: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string,
  showCurrent: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.bool
};

MapContainer.defaultProps = {
  locations: {
    edges: []
  },
  current: '-1',
  showCurrent: false
};

function mapStateToProps(state) {
  return {
    current: state.map.current,
    showCurrent: state.map.showCurrent
  };
}

/* harmony default export */ __webpack_exports__["a"] = (__webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_react_redux__["connect"])(mapStateToProps)(MapContainer));

/***/ }),

/***/ 99:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";

var ActionTypes = {
  SEARCH: 'SEARCH',

  MARKER_CLICK: 'MARKER_CLICK',
  MARKER_CLOSE: 'MARKER_CLOSE'
};

/* harmony default export */ __webpack_exports__["a"] = (ActionTypes);

/***/ })

},[277]);
//# sourceMappingURL=main.js.map