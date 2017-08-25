webpackJsonp([0],{

/***/ 171:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.openMarker = openMarker;
exports.highlightLocation = highlightLocation;
exports.closeMarker = closeMarker;

var _ActionTypes = __webpack_require__(57);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function openMarker(target) {
  return {
    type: _ActionTypes2.default.MARKER_CLICK,
    payload: {
      key: target
    }
  };
}

function highlightLocation(target) {
  return {
    type: _ActionTypes2.default.MARKER_CLICK,
    payload: target
  };
}

function closeMarker(target) {
  return {
    type: _ActionTypes2.default.MARKER_CLOSE,
    payload: target
  };
}

/***/ }),

/***/ 282:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

var _reactApollo = __webpack_require__(162);

var _reactRedux = __webpack_require__(94);

var _readLocations = __webpack_require__(310);

var _readLocations2 = _interopRequireDefault(_readLocations);

var _SearchBar = __webpack_require__(309);

var _SearchBar2 = _interopRequireDefault(_SearchBar);

var _MapArea = __webpack_require__(305);

var _MapArea2 = _interopRequireDefault(_MapArea);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
      if (this.props.loadedSettings === false) {
        return _react2.default.createElement('div', null);
      }
      return _react2.default.createElement(
        'div',
        null,
        _react2.default.createElement(_SearchBar2.default, null),
        _react2.default.createElement(_MapArea2.default, { locations: this.props.data.readLocations })
      );
    }
  }]);

  return Locator;
}(_react2.default.Component);

Locator.propTypes = {
  data: _propTypes2.default.shape({
    readLocations: _propTypes2.default.object
  }),
  loadedSettings: _propTypes2.default.bool.isRequired
};

Locator.defaultProps = {
  data: {
    readLocations: {}
  }
};

function mapStateToProps(state) {
  return {
    address: state.search.address,
    radius: state.search.radius,
    category: state.search.category,
    unit: state.settings.unit,
    loadedSettings: state.settings.loadedSettings
  };
}

exports.default = (0, _reactApollo.compose)((0, _reactRedux.connect)(mapStateToProps), (0, _reactApollo.graphql)(_readLocations2.default, {
  skip: function skip(_ref) {
    var loadedSettings = _ref.loadedSettings;
    return !loadedSettings;
  },
  options: function options(_ref2) {
    var address = _ref2.address,
        radius = _ref2.radius,
        category = _ref2.category,
        unit = _ref2.unit;
    return {
      variables: {
        address: address,
        radius: radius,
        category: category,
        unit: unit
      }
    };
  }
}))(Locator);

/***/ }),

/***/ 283:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _templateObject = _taggedTemplateLiteral(['\n  query ($id: Int!){\n    locatorSettings (ID: $id){\n      Limit,\n      Radii,\n      Unit,\n      Categories,\n      InfoWindowTemplate,\n      ListTemplate\n    }\n  }\n'], ['\n  query ($id: Int!){\n    locatorSettings (ID: $id){\n      Limit,\n      Radii,\n      Unit,\n      Categories,\n      InfoWindowTemplate,\n      ListTemplate\n    }\n  }\n']);

var _graphqlTag = __webpack_require__(73);

var _graphqlTag2 = _interopRequireDefault(_graphqlTag);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _taggedTemplateLiteral(strings, raw) { return Object.freeze(Object.defineProperties(strings, { raw: { value: Object.freeze(raw) } })); }

exports.default = (0, _graphqlTag2.default)(_templateObject);

/***/ }),

/***/ 284:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = reducers;

var _redux = __webpack_require__(53);

var _searchReducer = __webpack_require__(312);

var _searchReducer2 = _interopRequireDefault(_searchReducer);

var _mapReducer = __webpack_require__(311);

var _mapReducer2 = _interopRequireDefault(_mapReducer);

var _settingsReducer = __webpack_require__(313);

var _settingsReducer2 = _interopRequireDefault(_settingsReducer);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function reducers(client) {
  return (0, _redux.combineReducers)({
    client: client.reducer(),
    search: _searchReducer2.default,
    map: _mapReducer2.default,
    settings: _settingsReducer2.default
  });
}

/***/ }),

/***/ 301:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.search = search;

var _ActionTypes = __webpack_require__(57);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function search(inputs) {
  return {
    type: _ActionTypes2.default.SEARCH,
    payload: inputs
  };
}

/***/ }),

/***/ 302:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _reactDom = __webpack_require__(97);

var _reactDom2 = _interopRequireDefault(_reactDom);

var _redux = __webpack_require__(53);

var _reduxThunk = __webpack_require__(285);

var _reduxThunk2 = _interopRequireDefault(_reduxThunk);

var _apolloClient = __webpack_require__(161);

var _apolloClient2 = _interopRequireDefault(_apolloClient);

var _reactApollo = __webpack_require__(162);

var _reducers = __webpack_require__(284);

var _reducers2 = _interopRequireDefault(_reducers);

var _Locator = __webpack_require__(282);

var _Locator2 = _interopRequireDefault(_Locator);

var _locatorSettings = __webpack_require__(283);

var _locatorSettings2 = _interopRequireDefault(_locatorSettings);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var container = document.querySelector('.locator');

var client = new _apolloClient2.default({
  networkInterface: (0, _apolloClient.createNetworkInterface)({
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
  return (0, _redux.compose)((0, _redux.applyMiddleware)(client.middleware(), _reduxThunk2.default), typeof window.__REDUX_DEVTOOLS_EXTENSION__ !== 'undefined' ? window.__REDUX_DEVTOOLS_EXTENSION__() : function (f) {
    return f;
  });
}

var store = (0, _redux.createStore)((0, _reducers2.default)(client), composedMiddleware());

_reactDom2.default.render(_react2.default.createElement(
  _reactApollo.ApolloProvider,
  { store: store, client: client },
  _react2.default.createElement(_Locator2.default, null)
), container);

client.query({
  query: _locatorSettings2.default,
  variables: {
    id: container.dataset.locatorId
  }
});

/***/ }),

/***/ 303:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

var _htmlToReact = __webpack_require__(197);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
    key: 'getDistance',
    value: function getDistance() {
      var _props = this.props,
          location = _props.location,
          search = _props.search;

      var distance = location.distance;
      distance = parseFloat(distance);

      if (distance === 0 && !search) {
        return false;
      }

      return distance.toFixed(2);
    }
  }, {
    key: 'getDaddr',
    value: function getDaddr() {
      var location = this.props.location;

      var daddr = '';

      if (location.Address) {
        daddr += location.Address + '+';
      }

      if (location.Address2) {
        daddr += location.Address2 + '+';
      }

      if (location.City) {
        daddr += location.City + '+';
      }

      if (location.State) {
        daddr += location.State + '+';
      }

      if (location.PostalCode) {
        daddr += location.PostalCode;
      }

      return daddr.replace(/([+\s]+$)/g, '').replace(/(\s)/g, '+');
    }
  }, {
    key: 'render',
    value: function render() {
      var _props2 = this.props,
          location = _props2.location,
          index = _props2.index,
          current = _props2.current,
          search = _props2.search,
          template = _props2.template,
          unit = _props2.unit,
          _onClick = _props2.onClick;

      var htmlToReactParser = new _htmlToReact.Parser();

      var loc = _extends({}, location, {
        Distance: this.getDistance(),
        DirectionsLink: 'http://maps.google.com/maps?saddr=' + search + '&daddr=' + this.getDaddr(),
        Unit: unit,
        Number: index + 1
      });

      var className = 'list-location';
      if (current === location.ID) {
        className += ' focus';
      }
      return _react2.default.createElement(
        'li',
        { 'data-markerid': index, className: className, onClick: function onClick() {
            return _onClick(location.ID);
          } },
        htmlToReactParser.parse(template(loc))
      );
    }
  }]);

  return Location;
}(_react2.default.Component);

Location.propTypes = {
  location: _propTypes2.default.shape({
    Title: _propTypes2.default.string,
    Address: _propTypes2.default.string,
    Address2: _propTypes2.default.string,
    City: _propTypes2.default.string,
    State: _propTypes2.default.string,
    PostalCode: _propTypes2.default.string,
    Website: _propTypes2.default.string,
    Phone: _propTypes2.default.string,
    Email: _propTypes2.default.string,
    distance: _propTypes2.default.string
  }).isRequired,
  index: _propTypes2.default.number.isRequired,
  current: _propTypes2.default.string.isRequired,
  search: _propTypes2.default.string.isRequired,
  unit: _propTypes2.default.string.isRequired,
  onClick: _propTypes2.default.func.isRequired,
  template: _propTypes2.default.func.isRequired
};

exports.default = Location;

/***/ }),

/***/ 304:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _reactGoogleMaps = __webpack_require__(654);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var Map = (0, _reactGoogleMaps.withGoogleMap)(function (props) {
  return _react2.default.createElement(
    _reactGoogleMaps.GoogleMap,
    {
      defaultZoom: 9,
      defaultCenter: { lat: 43.8483258, lng: -87.7709294 }

    },
    props.markers.map(function (marker) {
      return _react2.default.createElement(
        _reactGoogleMaps.Marker,
        {
          key: marker.key,
          position: marker.position,
          defaultAnimation: marker.defaultAnimation,
          onClick: function onClick() {
            return props.onMarkerClick(marker);
          }
        },
        props.current === marker.key && props.showCurrent && _react2.default.createElement(
          _reactGoogleMaps.InfoWindow,
          { onCloseClick: function onCloseClick() {
              return props.onMarkerClose(marker);
            } },
          _react2.default.createElement(
            'div',
            null,
            marker.infoContent
          )
        )
      );
    })
  );
});

exports.default = Map;

/***/ }),

/***/ 305:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

var _reactRedux = __webpack_require__(94);

var _mapActions = __webpack_require__(171);

var _Location = __webpack_require__(303);

var _Location2 = _interopRequireDefault(_Location);

var _MapContainer = __webpack_require__(306);

var _MapContainer2 = _interopRequireDefault(_MapContainer);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var MapArea = function (_React$Component) {
  _inherits(MapArea, _React$Component);

  function MapArea(props) {
    _classCallCheck(this, MapArea);

    var _this = _possibleConstructorReturn(this, (MapArea.__proto__ || Object.getPrototypeOf(MapArea)).call(this, props));

    _this.handleLocationClick = _this.handleLocationClick.bind(_this);
    return _this;
  }

  _createClass(MapArea, [{
    key: 'handleLocationClick',
    value: function handleLocationClick(target) {
      this.props.dispatch((0, _mapActions.openMarker)(target));
    }
  }, {
    key: 'renderLocations',
    value: function renderLocations() {
      var _this2 = this;

      var _props = this.props,
          current = _props.current,
          search = _props.search,
          unit = _props.unit,
          template = _props.template;

      var locs = this.props.locations.edges;
      if (locs !== undefined) {
        return locs.map(function (location, index) {
          return _react2.default.createElement(_Location2.default, {
            key: location.node.ID,
            index: index,
            location: location.node,
            current: current,
            search: search,
            unit: unit,
            onClick: _this2.handleLocationClick,
            template: template
          });
        });
      }
      return null;
    }
  }, {
    key: 'render',
    value: function render() {
      return _react2.default.createElement(
        'div',
        { className: 'map-area' },
        _react2.default.createElement(_MapContainer2.default, { locations: this.props.locations }),
        _react2.default.createElement(
          'div',
          { className: 'loc-list' },
          _react2.default.createElement(
            'ul',
            null,
            this.renderLocations()
          )
        )
      );
    }
  }]);

  return MapArea;
}(_react2.default.Component);

MapArea.propTypes = {
  locations: _propTypes2.default.shape({
    edges: _propTypes2.default.array
  }),
  current: _propTypes2.default.string,
  search: _propTypes2.default.string,
  unit: _propTypes2.default.string.isRequired,
  dispatch: _propTypes2.default.func.isRequired
};

MapArea.defaultProps = {
  locations: {
    edges: []
  },
  current: '-1',
  search: ''
};

function mapStateToProps(state) {
  return {
    current: state.map.current,
    search: state.search.address,
    unit: state.settings.unit,
    template: state.settings.listTemplate
  };
}

exports.default = (0, _reactRedux.connect)(mapStateToProps)(MapArea);

/***/ }),

/***/ 306:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

var _reactRedux = __webpack_require__(94);

var _htmlToReact = __webpack_require__(197);

var _mapActions = __webpack_require__(171);

var _Map = __webpack_require__(304);

var _Map2 = _interopRequireDefault(_Map);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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

      var htmlToReactParser = new _htmlToReact.Parser();

      var i = void 0;

      for (i = 0; i < locations.length; i++) {
        var loc = locations[i].node;
        markers[markers.length] = {
          position: {
            lat: Number(loc.Lat),
            lng: Number(loc.Lng)
          },
          key: loc.ID,
          defaultAnimation: 2,
          infoContent: _react2.default.createElement(
            'div',
            null,
            htmlToReactParser.parse(this.props.template(loc))
          )
        };
      }
      return markers;
    }
  }, {
    key: 'handleMarkerClick',
    value: function handleMarkerClick(target) {
      this.props.dispatch((0, _mapActions.highlightLocation)(target));
    }
  }, {
    key: 'handleMarkerClose',
    value: function handleMarkerClose(target) {
      this.props.dispatch((0, _mapActions.closeMarker)(target));
    }
  }, {
    key: 'render',
    value: function render() {
      return _react2.default.createElement(
        'div',
        { id: 'map-container' },
        _react2.default.createElement(_Map2.default, {
          containerElement: _react2.default.createElement('div', { className: 'map' }),
          mapElement: _react2.default.createElement('div', { style: { height: '100%' } }),
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
}(_react2.default.Component);

MapContainer.propTypes = {
  locations: _propTypes2.default.shape({
    edges: _propTypes2.default.array
  }),
  dispatch: _propTypes2.default.func.isRequired,
  current: _propTypes2.default.string,
  showCurrent: _propTypes2.default.bool
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
    showCurrent: state.map.showCurrent,
    template: state.settings.infoWindowTemplate
  };
}

exports.default = (0, _reactRedux.connect)(mapStateToProps)(MapContainer);

/***/ }),

/***/ 307:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var CategoryDropDown = function (_React$Component) {
  _inherits(CategoryDropDown, _React$Component);

  function CategoryDropDown() {
    _classCallCheck(this, CategoryDropDown);

    return _possibleConstructorReturn(this, (CategoryDropDown.__proto__ || Object.getPrototypeOf(CategoryDropDown)).apply(this, arguments));
  }

  _createClass(CategoryDropDown, [{
    key: 'mappedCategories',
    value: function mappedCategories() {
      var categories = this.props.categories;


      return Object.keys(categories).map(function (key) {
        return _react2.default.createElement(
          'option',
          {
            value: key,
            key: key
          },
          categories[key]
        );
      });
    }
  }, {
    key: 'render',
    value: function render() {
      var categories = this.props.categories;

      if (categories !== undefined && Object.keys(categories).length !== 0) {
        return _react2.default.createElement(
          'div',
          { className: 'field dropdown form-group--no-label' },
          _react2.default.createElement(
            'div',
            { className: 'middleColumn' },
            _react2.default.createElement(
              'select',
              {
                name: 'category',
                className: 'dropdown form-group--no-label',
                defaultValue: ''
              },
              _react2.default.createElement(
                'option',
                { value: '' },
                'category'
              ),
              this.mappedCategories()
            )
          )
        );
      }
      return null;
    }
  }]);

  return CategoryDropDown;
}(_react2.default.Component);

CategoryDropDown.propTypes = {
  categories: _propTypes2.default.oneOfType([_propTypes2.default.object, _propTypes2.default.array]).isRequired
};

exports.default = CategoryDropDown;

/***/ }),

/***/ 308:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
      var radii = this.props.radii;


      return Object.keys(radii).map(function (key) {
        return _react2.default.createElement(
          'option',
          {
            value: radii[key],
            key: key
          },
          radii[key]
        );
      });
    }
  }, {
    key: 'render',
    value: function render() {
      var radii = this.props.radii;

      if (radii !== undefined && Object.keys(radii).length !== 0) {
        return _react2.default.createElement(
          'div',
          { className: 'field dropdown form-group--no-label' },
          _react2.default.createElement(
            'div',
            { className: 'middleColumn' },
            _react2.default.createElement(
              'select',
              {
                name: 'radius',
                className: 'dropdown form-group--no-label',
                defaultValue: ''
              },
              _react2.default.createElement(
                'option',
                { value: '' },
                'radius'
              ),
              this.mappedRadii()
            )
          )
        );
      }
      return null;
    }
  }]);

  return RadiusDropDown;
}(_react2.default.Component);

RadiusDropDown.propTypes = {
  radii: _propTypes2.default.oneOfType([_propTypes2.default.object, _propTypes2.default.array]).isRequired
};

exports.default = RadiusDropDown;

/***/ }),

/***/ 309:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _propTypes = __webpack_require__(4);

var _propTypes2 = _interopRequireDefault(_propTypes);

var _reactRedux = __webpack_require__(94);

var _searchActions = __webpack_require__(301);

var _RadiusDropDown = __webpack_require__(308);

var _RadiusDropDown2 = _interopRequireDefault(_RadiusDropDown);

var _CategoryDropDown = __webpack_require__(307);

var _CategoryDropDown2 = _interopRequireDefault(_CategoryDropDown);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
      var categoryInput = document.getElementsByName('category')[0].value;

      this.props.dispatch((0, _searchActions.search)({
        address: addressInput,
        radius: radiusInput,
        category: categoryInput
      }));
    }
  }, {
    key: 'render',
    value: function render() {
      return _react2.default.createElement(
        'form',
        { action: '', onSubmit: this.handleSubmit },
        _react2.default.createElement(
          'fieldset',
          null,
          _react2.default.createElement(
            'div',
            { className: 'field text form-group--no-label' },
            _react2.default.createElement(
              'div',
              { className: 'middleColumn' },
              _react2.default.createElement('input', {
                type: 'text',
                name: 'address',
                className: 'text form-group--no-label',
                'aria-required': 'true',
                placeholder: 'address or zip code'
              })
            )
          ),
          _react2.default.createElement(_RadiusDropDown2.default, { radii: this.props.radii }),
          _react2.default.createElement(_CategoryDropDown2.default, { categories: this.props.categories })
        ),
        _react2.default.createElement(
          'div',
          { className: 'btn-toolbar' },
          _react2.default.createElement('input', {
            type: 'submit',
            value: 'Search',
            className: 'action'
          })
        ),
        _react2.default.createElement('div', { className: 'clear' })
      );
    }
  }]);

  return SearchBar;
}(_react2.default.Component);

SearchBar.propTypes = {
  radii: _propTypes2.default.oneOfType([_propTypes2.default.object, _propTypes2.default.array]).isRequired,

  categories: _propTypes2.default.oneOfType([_propTypes2.default.object, _propTypes2.default.array]).isRequired,
  dispatch: _propTypes2.default.func.isRequired
};

function mapStateToProps(state) {
  return {
    radii: state.settings.radii,
    categories: state.settings.categories
  };
}

exports.default = (0, _reactRedux.connect)(mapStateToProps)(SearchBar);

/***/ }),

/***/ 310:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _templateObject = _taggedTemplateLiteral(['\n  query($address: String, $radius: String, $category: String, $unit: String){\n    readLocations(address: $address, radius: $radius, category: $category, unit: $unit) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n          distance\n          Category {\n            ID\n            Name\n          }\n        }\n      } \n    }\n  }\n'], ['\n  query($address: String, $radius: String, $category: String, $unit: String){\n    readLocations(address: $address, radius: $radius, category: $category, unit: $unit) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n          distance\n          Category {\n            ID\n            Name\n          }\n        }\n      } \n    }\n  }\n']);

var _graphqlTag = __webpack_require__(73);

var _graphqlTag2 = _interopRequireDefault(_graphqlTag);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _taggedTemplateLiteral(strings, raw) { return Object.freeze(Object.defineProperties(strings, { raw: { value: Object.freeze(raw) } })); }

exports.default = (0, _graphqlTag2.default)(_templateObject);

/***/ }),

/***/ 311:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.default = reducer;

var _ActionTypes = __webpack_require__(57);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var defaultState = {
  current: '-1',
  showCurrent: false
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case _ActionTypes2.default.MARKER_CLICK:
      return _extends({}, state, {
        current: action.payload.key,
        showCurrent: true
      });

    case _ActionTypes2.default.MARKER_CLOSE:
      return _extends({}, state, {
        showCurrent: false
      });

    case _ActionTypes2.default.SEARCH:
      return _extends({}, state, {
        current: '-1',
        showCurrent: false
      });

    default:
      return state;
  }
}

/***/ }),

/***/ 312:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.default = reducer;

var _ActionTypes = __webpack_require__(57);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var defaultState = {
  address: '',
  radius: '',
  category: ''
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case _ActionTypes2.default.SEARCH:
      return _extends({}, state, {
        address: action.payload.address,
        radius: action.payload.radius,
        category: action.payload.category
      });

    default:
      return state;
  }
}

/***/ }),

/***/ 313:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.default = reducer;

var _handlebars = __webpack_require__(409);

var _handlebars2 = _interopRequireDefault(_handlebars);

var _ActionTypes = __webpack_require__(57);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var defaultState = {
  loadedSettings: false
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case _ActionTypes2.default.QUERY_RESULT:
      {
        var settings = action.result.data.locatorSettings;

        if (settings === undefined) {
          return state;
        }

        if (settings.constructor === Array) {
          settings = settings[0];
        }

        if (settings.Unit === null) {
          settings.Unit = 'm';
        }

        return _extends({}, state, {
          loadedSettings: true,

          unit: settings.Unit,
          limit: settings.Limit,
          radii: JSON.parse(settings.Radii),
          categories: JSON.parse(settings.Categories),
          infoWindowTemplate: _handlebars2.default.compile(JSON.parse(settings.InfoWindowTemplate)),
          listTemplate: _handlebars2.default.compile(JSON.parse(settings.ListTemplate))
        });
      }

    default:
      return state;
  }
}

/***/ }),

/***/ 57:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var ActionTypes = {
  QUERY_RESULT: 'APOLLO_QUERY_RESULT',

  SEARCH: 'SEARCH',

  MARKER_CLICK: 'MARKER_CLICK',
  MARKER_CLOSE: 'MARKER_CLOSE'
};

exports.default = ActionTypes;

/***/ })

},[302]);
//# sourceMappingURL=main.js.map