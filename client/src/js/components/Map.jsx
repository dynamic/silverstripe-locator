import React from 'react';
import Location from './Location';

class Map extends React.Component {
  renderLocations() {
    if (this.props.locations !== undefined) {
      return this.props.locations.map(radius =>
        <Location />,
      );
    }
    return (<Location />);
  }

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

export default Map;
