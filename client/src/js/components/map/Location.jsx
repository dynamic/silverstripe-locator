import React from 'react';
import PropTypes from 'prop-types';

/**
 * The Location component.
 * Used in the location list.
 */
class Location extends React.Component {
  /**
   * Rounds the distance
   */
  getDistance() {
    const { location } = this.props;
    let distance = location.distance;
    distance = parseFloat(distance);
    return distance.toFixed(2);
  }

  /**
   * Gets the daddr string for google maps directions
   * @returns {string}
   */
  getDaddr() {
    const { location } = this.props;
    let daddr = '';

    if (location.Address) {
      daddr += `${location.Address}+`;
    }

    if (location.Address2) {
      daddr += `${location.Address2}+`;
    }

    if (location.City) {
      daddr += `${location.City}+`;
    }

    if (location.State) {
      daddr += `${location.State}+`;
    }

    if (location.PostalCode) {
      daddr += location.PostalCode;
    }

    // return daddr after replacing any trailing '+' and whitespace
    return daddr.replace(/([+\s]+$)/g, '');
  }

  /**
   * Renders the distance for the location
   * Only renders when there is a search
   * @returns {*}
   */
  renderDistance() {
    const distance = this.getDistance();
    const { search } = this.props;

    if (search) {
      const link = `http://maps.google.com/maps?saddr=${search}&daddr=${this.getDaddr()}`;
      return (
        <div className="loc-dist">
          {distance} |
          <a
            href={link}
            target="_blank"
            rel="noopener noreferrer"
          >Directions</a>
        </div>);
    }
    return null;
  }

  /**
   * renders the component
   * @returns {XML}
   */
  render() {
    const { location, index, current } = this.props;
    let className = '';
    if (current === location.ID) {
      className += 'focus';
    }
    return (
      <li data-markerid={index} className={className}>
        <div className="list-label">{index + 1}</div>
        <div className="list-details">
          <div className="list-content">
            <div className="loc-name">{location.Title}</div>
            <div className="loc-addr">{location.Address}</div>

            {location.Address2 &&
            <div className="loc-addr2">{location.Address2}</div>
            }
            <div className="loc-addr3">{location.City}, {location.State} {location.PostalCode}</div>

            {location.Phone &&
            <div className="loc-phone">{location.Phone}</div>
            }

            {location.Website &&
            <div className="loc-web">
              <a href={location.Website} target="_blank" rel="noopener noreferrer">Website</a>
            </div>}

            {location.Email &&
            <div className="loc-email">
              <a href={`mailto:${location.Email}`}>Email</a>
            </div>
            }
            {this.renderDistance()}
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
    Email: PropTypes.string,
    distance: PropTypes.string,
  }).isRequired,
  index: PropTypes.number.isRequired,
  current: PropTypes.string.isRequired,
  search: PropTypes.string.isRequired,
};

/**
 * Exports the Location components
 */
export default Location;
