import React from 'react';
import PropTypes from 'prop-types';

class RadiusDropDown extends React.Component {
  /**
   * Maps the radii into options for the drop down.
   * @returns {Array}
   */
  mappedRadii() {
    const { radii, unit } = this.props;

    return Object.keys(radii).map(key => (
      <option
        value={radii[key]}
        key={key}
      >
        {radii[key]} {unit}
      </option>
    ));
  }

  /**
   * Gets the default value for the dropdown
   * @return {*}
   */
  defaultValue() {
    const { radius, radii } = this.props;

    // if the radius exists in the dropdown
    const values = Object.keys(radii).map(
      key => radii[key],
    );
    if (values.indexOf(radius) > -1) {
      return radius;
    }
    return '';
  }

  /**
   * Outputs the radius drop down.
   * @returns {*}
   */
  render() {
    const { radii } = this.props;
    if (radii !== undefined && Object.keys(radii).length !== 0) {
      return (
        <div className="radius-dropdown form-group">
          <label htmlFor="radius" className="sr-only">Radius</label>
          <select
            name="radius"
            className="form-control"
            defaultValue={this.defaultValue()}
          >
            <option value="">radius</option>
            {this.mappedRadii()}
          </select>
        </div>
      );
    }
    return null;
  }
}

RadiusDropDown.propTypes = {
  radius: PropTypes.number.isRequired,
  // eslint-disable-next-line react/forbid-prop-types
  radii: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
  unit: PropTypes.string.isRequired,
};

export default RadiusDropDown;
