import React from 'react';
import PropTypes from 'prop-types';
import { withGoogleMap, GoogleMap, Marker } from 'react-google-maps';

import Location from './Location';

const GoogleMapComponent = withGoogleMap(props => (
  <GoogleMap
    defaultZoom={9}
    defaultCenter={{ lat: 43.8483258, lng: -87.7709294 }}
  >
    {props.markers.map(marker => (
      <Marker
        {...marker}
      />
    ))}
  </GoogleMap>
));

/**
 * The Map component.
 * Renders the map div and location list.
 */
class Map extends React.Component {
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
            <div style={{ height: '100%' }} />
          }
          mapElement={
            <div style={{ height: '100%' }} />
          }
          markers={this.getMarkers()}
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
export default Map;
