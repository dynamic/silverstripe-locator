import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Parser as HtmlToReactParser } from 'html-to-react';

import { highlightLocation, closeMarker } from 'actions/mapActions';
import Map from 'components/map/Map';

/**
 * The MapArea component.
 * Renders the map.
 */
class MapContainer extends React.Component {
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

    const htmlToReactParser = new HtmlToReactParser();

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
        infoContent: (
          <div>
            {htmlToReactParser.parse(this.props.template(loc))}
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
    this.props.dispatch(highlightLocation(target));
  }

  /**
   * Fires event for closing a marker info box
   * @param target The marker that had its info box closed
   */
  handleMarkerClose(target) {
    this.props.dispatch(closeMarker(target));
  }

  render() {
    return (
      <div id="map-container">
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
          current={this.props.current}
          showCurrent={this.props.showCurrent}
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
  locations: PropTypes.shape({
    edges: PropTypes.array,
  }),
  dispatch: PropTypes.func.isRequired,
  current: PropTypes.string,
  showCurrent: PropTypes.bool,
};

/**
 * Defines the default values of the props
 * @type {{locations: {edges: Array}}}
 */
MapContainer.defaultProps = {
  locations: {
    edges: [],
  },
  current: '-1',
  showCurrent: false,
};

/**
 * Maps that state to props
 * @param state
 * @returns {{current}}
 */
function mapStateToProps(state) {
  return {
    current: state.map.current,
    showCurrent: state.map.showCurrent,
    template: state.settings.infoWindowTemplate,
  };
}

export default connect(mapStateToProps)(MapContainer);
