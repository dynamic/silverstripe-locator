import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Parser as HtmlToReactParser } from 'html-to-react';

/**
 * The Location component.
 * Used in the location list.
 */
class Location extends Component {
  /**
   * Rounds the distance
   * @returns Number|Boolean
   */
  getDistance() {
    const { location, search } = this.props;
    let distance = location.distance;
    distance = parseFloat(distance);

    if (distance === 0 && !search) {
      return false;
    }

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

    return this.cleanAddress(daddr);
  }

  /**
   * Replaces any trailing '+' and whitespace and any spaces left with '+'
   *
   * @param address
   * @returns String
   */
  cleanAddress(address) {
    return address.replace(/([+\s]+$)/g, '').replace(/(\s)/g, '+');
  }

  /**
   * renders the component
   * @returns {XML}
   */
  render() {
    const { location, index, current, search, template, unit, onClick } = this.props;
    const htmlToReactParser = new HtmlToReactParser();

    const loc = {
      ...location,
      Distance: this.getDistance(),
      DirectionsLink: `http://maps.google.com/maps?saddr=${this.cleanAddress(search)}&daddr=${this.getDaddr()}`,
      Unit: unit,
      Number: index + 1,
    };

    let className = 'list-location';
    if (current) {
      className += ' focus';
    }
    return (
      // eslint-disable-next-line jsx-a11y/no-noninteractive-element-interactions
      <li data-markerid={index} className={className} onClick={() => onClick(location.ID)}>
        {htmlToReactParser.parse(template(loc))}
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
    Distance: PropTypes.number,
  }).isRequired,
  index: PropTypes.number.isRequired,
  current: PropTypes.bool.isRequired,
  search: PropTypes.string.isRequired,
  unit: PropTypes.string.isRequired,
  onClick: PropTypes.func.isRequired,
  template: PropTypes.func.isRequired,
};

/**
 * Exports the Location components
 */
export default Location;
