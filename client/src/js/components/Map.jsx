import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { withGoogleMap, GoogleMap, Marker, InfoWindow } from 'react-google-maps';

import ActionType from 'actions/ActionTypes';
import Location from './Location';

const GoogleMapComponent = withGoogleMap(props => (
  <GoogleMap
    defaultZoom={9}
    defaultCenter={{ lat: 43.8483258, lng: -87.7709294 }}
  >
    {props.markers.map(marker => (
      <Marker
        key={marker.key}
        position={marker.position}
        defaultAnimation={marker.defaultAnimation}
        onClick={() => props.onMarkerClick(marker)}
      >
        {marker.showInfo && (
          <InfoWindow onCloseClick={() => props.onMarkerClose(marker)}>
            <div>{marker.infoContent}</div>
          </InfoWindow>
        )}
      </Marker>
    ))}
  </GoogleMap>
));

/**
 * The Map component.
 * Renders the map div and location list.
 */
class Map extends React.Component {
  /**
   * Used to create the Map.
   * needed to allow use of this keyword in handler.
   * @param props
   */
  constructor(props) {
    super(props);
    this.handleMarkerClick = this.handleMarkerClick.bind(this);
    this.handleMarkerClose = this.handleMarkerClose.bind(this);
  }

  /**
   * Generates an array of marker objects to use on the map
   */
  getMarkers() {
    const locations = this.props.locations.edges;
    const markers = [];

    let i;
    // eslint-disable-next-line no-plusplus
    for (i = 0; i < locations.length; i++) {
      const loc = locations[i].node;
      markers[markers.length] = {
        position: {
          lat: Number(loc.Lat),
          lng: Number(loc.Lng),
        },
        key: loc.ID,
        defaultAnimation: 2,
      };
    }
    return markers;
  }

  /**
   * Fires and event for clicking a marker
   * @param target The marker that was clicked
   */
  handleMarkerClick(target) {
    this.props.dispatch({
      type: ActionType.MARKER_CLICK,
      payload: target,
    });
  }

  /**
   * Fires event for closing a marker info box
   * @param target The marker that had its info box closed
   */
  handleMarkerClose(target) {
    this.props.dispatch({
      type: ActionType.MARKER_CLOSE,
      payload: target,
    });
  }

  /**
   * Renders the locations
   * @returns {*}
   */
  renderLocations() {
    const locs = this.props.locations.edges;
    if (locs !== undefined) {
      return locs.map((location, index) =>
        (
          <Location
            key={location.node.ID}
            index={index}
            location={location.node}
          />
        ),
      );
    }
    return null;
  }

  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    return (
      <div id="map-container">
        <GoogleMapComponent
          containerElement={
            <div className="map" />
          }
          mapElement={
            <div style={{ height: '100%' }} />
          }
          markers={this.getMarkers()}
          onMarkerClick={this.handleMarkerClick}
          onMarkerClose={this.handleMarkerClose}
        />
        <div className="loc-list">
          <ul>
            {this.renderLocations()}
          </ul>
        </div>
      </div>
    );
  }
}

/**
 * Defines the prop types
 * @type {{locations: *}}
 */
Map.propTypes = {
  locations: PropTypes.shape({
    edges: PropTypes.array,
  }),
  dispatch: PropTypes.func.isRequired,
};

/**
 * Defines the default values of the props
 * @type {{locations: {edges: Array}}}
 */
Map.defaultProps = {
  locations: {
    edges: [],
  },
};

/**
 * export the Map Component
 */
export default connect()(Map);
