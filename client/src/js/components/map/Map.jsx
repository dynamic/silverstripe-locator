import React from 'react';
import { withGoogleMap, GoogleMap, Marker, InfoWindow } from 'react-google-maps';
import MarkerClusterer from 'react-google-maps/lib/addons/MarkerClusterer';

const markers = props => props.markers.map(marker => (
  <Marker
    key={marker.key}
    position={marker.position}
    defaultAnimation={marker.defaultAnimation}
    onClick={() => props.onMarkerClick(marker)}
  >
    {props.current === marker.key && props.showCurrent && (
      <InfoWindow onCloseClick={() => props.onMarkerClose(marker)}>
        <div className="marker-content">{marker.infoContent}</div>
      </InfoWindow>
    )}
  </Marker>
));

const Map = withGoogleMap(props => (
  <GoogleMap
    defaultZoom={9}
    defaultCenter={{ lat: 43.8483258, lng: -87.7709294 }}

  >
    {props.clusters === 'true' ? <MarkerClusterer
      averageCenter
      enableRetinaIcons
      gridSize={60}
    >
      {markers(props)}
    </MarkerClusterer> :
      markers(props)}
  </GoogleMap>
));

export default Map;
