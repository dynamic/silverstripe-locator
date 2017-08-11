import React from 'react';
import PropTypes from 'prop-types';

/**
 * The Location component.
 * Used in the location list.
 */
class Location extends React.Component {
  /**
   * renders the component
   * @returns {XML}
   */
  render() {
    const { location, index, current } = this.props;
    let className = '';
    if (current === location.ID) {
      className = 'focus';
    }
    return (
      <li data-markerid={index} className={className}>
        <div className="list-label">{index + 1}</div>
        <div className="list-details">
          <div className="list-content">
            <div className="loc-name">{location.Title}</div>
            <div className="loc-addr">{location.Address}</div>
            {location.Address2 && <div className="loc-addr2">{location.Address2}</div>}
            <div className="loc-addr3">{location.City}, {location.State} {location.PostalCode}</div>
            {location.Phone && <div className="loc-phone">{location.Phone}</div>}
            {location.Website &&
            <div className="loc-web">
              <a href={location.Website} target="_blank" rel="noopener noreferrer">Website</a>
            </div>}
            {location.Email && <div className="loc-email"><a href={`mailto:${location.Email}`}>Email</a></div>}
            <div className="loc-dist">
              distance length |
              <a
                // TODO - update with proper values
                href="http://maps.google.com/maps?saddr={{origin}}&amp;daddr={{address}} {{address2}} {{city}}, {{state}} {{postal}}"
                target="_blank"
                rel="noopener noreferrer"
              >Directions</a>
            </div>
          </div>
        </div>
      </li>
    );
  }
}

/**
 * defines the prop types
 * @type {{location, index: *}}
 */
Location.propTypes = {
  location: PropTypes.shape({
    Title: PropTypes.string,
    Address: PropTypes.string,
    Address2: PropTypes.string,
    City: PropTypes.string,
    State: PropTypes.string,
    PostalCode: PropTypes.string,
    Website: PropTypes.string,
    Phone: PropTypes.string,
  }).isRequired,
  index: PropTypes.number.isRequired,
  current: PropTypes.string.isRequired,
};

/**
 * Exports the Location components
 */
export default Location;
