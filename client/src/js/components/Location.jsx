import React from 'react';
import PropTypes from 'prop-types';

/**
 * The Location component.
 * Used in the location list.
 */
class Location extends React.Component {
  /**
   * Renders Address 3 line
   * @returns {XML}
   */
  addressThree() {
    const { City, State, PostalCode } = this.props.location;
    if (City !== null && State !== null && PostalCode !== null) {
      return <div className="loc-addr3">{City}, {State} {PostalCode}</div>;
    } else if (City === null && State !== null && PostalCode !== null) {
      return <div className="loc-addr3">{State} {PostalCode}</div>;
    } else if (City !== null && State === null && PostalCode !== null) {
      return <div className="loc-addr3">{City} {PostalCode}</div>;
    }
    return <div className="loc-addr3" />;
  }

  /**
   * renders the link section (website/phone)
   * @returns {XML}
   */
  links() {
    const { Website, Phone } = this.props.location;
    if (Website !== null && Phone !== null) {
      return (
        <div>
          <a href={Website} target="_blank">website</a>
          &nbsp;|&nbsp;
          <a href={`tel:${Phone}`}>phone</a>
        </div>
      );
    } else if (Website !== null) {
      return (
        <div>
          <a href={Website} target="_blank">website</a>
        </div>
      );
    } else if (Phone !== null) {
      return (
        <div>
          <a href={`tel:${Phone}`}>phone</a>
        </div>
      );
    }
    return <div />;
  }

  /**
   * renders the component
   * @returns {XML}
   */
  render() {
    const { location, index } = this.props;
    return (
      <li data-markerid={index}>
        <div className="list-label">{index + 1}</div>
        <div className="list-details">
          <div className="list-content">
            <div className="loc-name">{location.Title}</div>
            <div className="loc-addr">{location.Address}</div>
            <div className="loc-addr2">{location.Address2}</div>
            {this.addressThree()}
            {this.links()}

            <div className="loc-dist">
              Distance
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
};

/**
 * Exports the Location components
 */
export default Location;
