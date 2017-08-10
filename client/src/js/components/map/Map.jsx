import React from 'react';
import { withGoogleMap, GoogleMap, Marker, InfoWindow } from 'react-google-maps';

const Map = withGoogleMap(props => (
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
        {props.current === marker.key && props.showCurrent && (
          <InfoWindow onCloseClick={() => props.onMarkerClose(marker)}>
            <div>{marker.infoContent}</div>
          </InfoWindow>
        )}
      </Marker>
    ))}
  </GoogleMap>
));

export default Map;
