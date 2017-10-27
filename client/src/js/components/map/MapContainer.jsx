import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Parser as HtmlToReactParser } from 'html-to-react';

import { highlightLocation, closeMarker } from 'actions/mapActions';
import Map from 'components/map/Map';

/**
 * The MapArea component.
 * Renders the map.
 */
export class MapContainer extends Component {
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
    const { locations, template } = this.props;
    const markers = [];

    const htmlToReactParser = new HtmlToReactParser();

    let i;
    // eslint-disable-next-line no-plusplus
    for (i = 0; i < locations.length; i++) {
      const loc = locations[i];
      const { Lat, Lng } = loc;
      markers[markers.length] = {
        position: {
          lat: Number(Lat),
          lng: Number(Lng),
        },
        key: loc.ID,
        defaultAnimation: 2,
        infoContent: (
          <div>
            {htmlToReactParser.parse(template(loc))}
          </div>
        ),
      };
    }
    return markers;
  }

  /**
   * Fires and event for clicking a marker
   * @param target The marker that was clicked
   */
  handleMarkerClick(target) {
    const { dispatch } = this.props;
    dispatch(highlightLocation(target));
  }

  /**
   * Fires event for closing a marker info box
   * @param target The marker that had its info box closed
   */
  handleMarkerClose(target) {
    const { dispatch } = this.props;
    dispatch(closeMarker(target));
  }

  render() {
    const { current, showCurrent, clusters } = this.props;
    return (
      <div className="map-container">
        <Map
          containerElement={
            <div className="map" />
          }
          mapElement={
            <div style={{ height: '100%' }} />
          }
          markers={this.getMarkers()}
          onMarkerClick={this.handleMarkerClick}
          onMarkerClose={this.handleMarkerClose}
          current={current}
          showCurrent={showCurrent}
          clusters={clusters}
        />
      </div>
    );
  }
}

/**
 * Defines the prop types
 * @type {{locations: *}}
 */
MapContainer.propTypes = {
  // eslint-disable-next-line react/forbid-prop-types
  locations: PropTypes.array,
  dispatch: PropTypes.func.isRequired,
  current: PropTypes.number.isRequired,
  showCurrent: PropTypes.bool.isRequired,
  clusters: PropTypes.bool.isRequired,
  template: PropTypes.func.isRequired,
};

/**
 * Defines the default values of the props
 * @type {{locations: {edges: Array}}}
 */
MapContainer.defaultProps = {
  locations: [],
};

/**
 * Maps that state to props
 * @param state
 * @returns {{current}}
 */
export function mapStateToProps(state) {
  return {
    current: state.map.current,
    showCurrent: state.map.showCurrent,
    clusters: state.settings.clusters,
    template: state.settings.infoWindowTemplate,
    locations: state.locations.locations,
  };
}

export default connect(mapStateToProps)(MapContainer);
