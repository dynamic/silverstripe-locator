webpackJsonp([0],{

/***/ 259:
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

var _reactApollo = __webpack_require__(151);

var _reactRedux = __webpack_require__(91);

var _readLocations = __webpack_require__(284);

var _readLocations2 = _interopRequireDefault(_readLocations);

var _SearchBar = __webpack_require__(283);

var _SearchBar2 = _interopRequireDefault(_SearchBar);

var _MapArea = __webpack_require__(280);

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
      var radii = [5, 25, 50, 75, 100];
      return _react2.default.createElement(
        'div',
        null,
        _react2.default.createElement(_SearchBar2.default, { radii: radii }),
        _react2.default.createElement(_MapArea2.default, { locations: this.props.data.readLocations })
      );
    }
  }]);

  return Locator;
}(_react2.default.Component);

Locator.propTypes = {
  data: _propTypes2.default.shape({
    readLocations: _propTypes2.default.object
  }).isRequired
};

function mapStateToProps(state) {
  return {
    address: state.search.address,
    radius: state.search.radius
  };
}

exports.default = (0, _reactApollo.compose)((0, _reactRedux.connect)(mapStateToProps), (0, _reactApollo.graphql)(_readLocations2.default, {
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
}))(Locator);

/***/ }),

/***/ 260:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = reducers;

var _redux = __webpack_require__(51);

var _searchReducer = __webpack_require__(286);

var _searchReducer2 = _interopRequireDefault(_searchReducer);

var _mapReducer = __webpack_require__(285);

var _mapReducer2 = _interopRequireDefault(_mapReducer);

var _settingsReducer = __webpack_require__(611);

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

/***/ 276:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.search = search;

var _ActionTypes = __webpack_require__(67);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function search(inputs) {
  return {
    type: _ActionTypes2.default.SEARCH,
    payload: inputs
  };
}

/***/ }),

/***/ 277:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _reactDom = __webpack_require__(94);

var _reactDom2 = _interopRequireDefault(_reactDom);

var _redux = __webpack_require__(51);

var _reduxThunk = __webpack_require__(261);

var _reduxThunk2 = _interopRequireDefault(_reduxThunk);

var _apolloClient = __webpack_require__(150);

var _apolloClient2 = _interopRequireDefault(_apolloClient);

var _reactApollo = __webpack_require__(151);

var _reducers = __webpack_require__(260);

var _reducers2 = _interopRequireDefault(_reducers);

var _Locator = __webpack_require__(259);

var _Locator2 = _interopRequireDefault(_Locator);

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

var defaultState = {
  settings: JSON.parse(container.dataset.mapSettings)
};

var store = (0, _redux.createStore)((0, _reducers2.default)(client), defaultState, composedMiddleware());

_reactDom2.default.render(_react2.default.createElement(
  _reactApollo.ApolloProvider,
  { store: store, client: client },
  _react2.default.createElement(_Locator2.default, null)
), container);

/***/ }),

/***/ 278:
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

var Location = function (_React$Component) {
  _inherits(Location, _React$Component);

  function Location() {
    _classCallCheck(this, Location);

    return _possibleConstructorReturn(this, (Location.__proto__ || Object.getPrototypeOf(Location)).apply(this, arguments));
  }

  _createClass(Location, [{
    key: 'getDistance',
    value: function getDistance() {
      var location = this.props.location;

      var distance = location.distance;
      distance = parseFloat(distance);
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

      return daddr.replace(/([+\s]+$)/g, '');
    }
  }, {
    key: 'renderDistance',
    value: function renderDistance() {
      var distance = this.getDistance();
      var search = this.props.search;


      if (search) {
        var link = 'http://maps.google.com/maps?saddr=' + search + '&daddr=' + this.getDaddr();
        return _react2.default.createElement(
          'div',
          { className: 'loc-dist' },
          distance,
          ' |',
          _react2.default.createElement(
            'a',
            {
              href: link,
              target: '_blank',
              rel: 'noopener noreferrer'
            },
            'Directions'
          )
        );
      }
      return null;
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
        className += 'focus';
      }
      return _react2.default.createElement(
        'li',
        { 'data-markerid': index, className: className },
        _react2.default.createElement(
          'div',
          { className: 'list-label' },
          index + 1
        ),
        _react2.default.createElement(
          'div',
          { className: 'list-details' },
          _react2.default.createElement(
            'div',
            { className: 'list-content' },
            _react2.default.createElement(
              'div',
              { className: 'loc-name' },
              location.Title
            ),
            _react2.default.createElement(
              'div',
              { className: 'loc-addr' },
              location.Address
            ),
            location.Address2 && _react2.default.createElement(
              'div',
              { className: 'loc-addr2' },
              location.Address2
            ),
            _react2.default.createElement(
              'div',
              { className: 'loc-addr3' },
              location.City,
              ', ',
              location.State,
              ' ',
              location.PostalCode
            ),
            location.Phone && _react2.default.createElement(
              'div',
              { className: 'loc-phone' },
              location.Phone
            ),
            location.Website && _react2.default.createElement(
              'div',
              { className: 'loc-web' },
              _react2.default.createElement(
                'a',
                { href: location.Website, target: '_blank', rel: 'noopener noreferrer' },
                'Website'
              )
            ),
            location.Email && _react2.default.createElement(
              'div',
              { className: 'loc-email' },
              _react2.default.createElement(
                'a',
                { href: 'mailto:' + location.Email },
                'Email'
              )
            ),
            this.renderDistance()
          )
        )
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
  search: _propTypes2.default.string.isRequired
};

exports.default = Location;

/***/ }),

/***/ 279:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _react = __webpack_require__(6);

var _react2 = _interopRequireDefault(_react);

var _reactGoogleMaps = __webpack_require__(583);

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

/***/ 280:
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

var _reactRedux = __webpack_require__(91);

var _Location = __webpack_require__(278);

var _Location2 = _interopRequireDefault(_Location);

var _MapContainer = __webpack_require__(281);

var _MapContainer2 = _interopRequireDefault(_MapContainer);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
          return _react2.default.createElement(_Location2.default, {
            key: location.node.ID,
            index: index,
            location: location.node,
            current: _this2.props.current,
            search: _this2.props.search
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
  search: _propTypes2.default.string
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
    search: state.search.address
  };
}

exports.default = (0, _reactRedux.connect)(mapStateToProps)(MapArea);

/***/ }),

/***/ 281:
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

var _reactRedux = __webpack_require__(91);

var _ActionTypes = __webpack_require__(67);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

var _Map = __webpack_require__(279);

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
            _react2.default.createElement(
              'div',
              { className: 'loc-name' },
              loc.Title
            ),
            _react2.default.createElement(
              'div',
              null,
              loc.Address
            ),
            _react2.default.createElement(
              'div',
              null,
              loc.Address2
            ),
            _react2.default.createElement(
              'div',
              null,
              loc.City,
              ', ',
              loc.State,
              ' ',
              loc.PostalCode
            ),
            loc.Phone && _react2.default.createElement(
              'a',
              { href: 'tel:' + loc.Phone },
              loc.Phone
            ),
            loc.Website && _react2.default.createElement(
              'div',
              null,
              _react2.default.createElement(
                'a',
                { href: loc.Website, target: '_blank', rel: 'noopener noreferrer' },
                'Website'
              )
            )
          )
        };
      }
      return markers;
    }
  }, {
    key: 'handleMarkerClick',
    value: function handleMarkerClick(target) {
      this.props.dispatch({
        type: _ActionTypes2.default.MARKER_CLICK,
        payload: target
      });
    }
  }, {
    key: 'handleMarkerClose',
    value: function handleMarkerClose(target) {
      this.props.dispatch({
        type: _ActionTypes2.default.MARKER_CLOSE,
        payload: target
      });
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
    showCurrent: state.map.showCurrent
  };
}

exports.default = (0, _reactRedux.connect)(mapStateToProps)(MapContainer);

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
      return this.props.radii.map(function (radius) {
        return _react2.default.createElement(
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
      } else {
        return null;
      }
    }
  }]);

  return RadiusDropDown;
}(_react2.default.Component);

RadiusDropDown.propTypes = {
  radii: _propTypes2.default.array.isRequired
};

exports.default = RadiusDropDown;

/***/ }),

/***/ 283:
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

var _reactRedux = __webpack_require__(91);

var _searchActions = __webpack_require__(276);

var _RadiusDropDown = __webpack_require__(282);

var _RadiusDropDown2 = _interopRequireDefault(_RadiusDropDown);

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

      this.props.dispatch((0, _searchActions.search)({
        address: addressInput,
        radius: radiusInput
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
                required: 'required',
                'aria-required': 'true',
                placeholder: 'address or zip code'
              })
            )
          ),
          _react2.default.createElement(_RadiusDropDown2.default, { radii: this.props.radii })
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
  radii: _propTypes2.default.array.isRequired,
  dispatch: _propTypes2.default.func.isRequired
};

exports.default = (0, _reactRedux.connect)()(SearchBar);

/***/ }),

/***/ 284:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _templateObject = _taggedTemplateLiteral(['\n  query($address: String, $radius: String, $category: String){\n    readLocations(address: $address, radius: $radius, category: $category) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n          distance\n          Category {\n            ID\n            Name\n          }\n        }\n      } \n    }\n  }\n'], ['\n  query($address: String, $radius: String, $category: String){\n    readLocations(address: $address, radius: $radius, category: $category) {\n      edges {\n        node {\n          ID\n          Title\n          Website\n          Email\n          Phone\n          Address\n          Address2\n          City\n          State\n          Country\n          PostalCode\n          Lat\n          Lng\n          distance\n          Category {\n            ID\n            Name\n          }\n        }\n      } \n    }\n  }\n']);

var _graphqlTag = __webpack_require__(177);

var _graphqlTag2 = _interopRequireDefault(_graphqlTag);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _taggedTemplateLiteral(strings, raw) { return Object.freeze(Object.defineProperties(strings, { raw: { value: Object.freeze(raw) } })); }

exports.default = (0, _graphqlTag2.default)(_templateObject);

/***/ }),

/***/ 285:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.default = reducer;

var _ActionTypes = __webpack_require__(67);

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

    default:
      return state;
  }
}

/***/ }),

/***/ 286:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

exports.default = reducer;

var _ActionTypes = __webpack_require__(67);

var _ActionTypes2 = _interopRequireDefault(_ActionTypes);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var defaultState = {
  address: '',
  radius: ''
};

function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : defaultState;
  var action = arguments[1];

  switch (action.type) {
    case _ActionTypes2.default.SEARCH:
      return _extends({}, state, {
        address: action.payload.address,
        radius: action.payload.radius
      });

    default:
      return state;
  }
}

/***/ }),

/***/ 611:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = reducer;
function reducer() {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var action = arguments[1];

  return state;
}

/***/ }),

/***/ 67:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});

var ActionTypes = {
  SEARCH: 'SEARCH',

  MARKER_CLICK: 'MARKER_CLICK',
  MARKER_CLOSE: 'MARKER_CLOSE'
};

exports.default = ActionTypes;

/***/ })

},[277]);
//# sourceMappingURL=main.js.map