import React from 'react';
import PropTypes from 'prop-types';

import Location from './Location';

/**
 * The Map component.
 * Renders the map div and location list.
 */
class Map extends React.Component {
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
        <div id="map" />
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
