import React from 'react';
import PropTypes from 'prop-types';

class RadiusDropDown extends React.Component {
  /**
   * Maps the radii into options for the drop down.
   * @returns {Array}
   */
  mappedRadii() {
    const { radii } = this.props;

    return Object.keys(radii).map(key => (
      <option
        value={radii[key]}
        key={key}
      >
        {radii[key]}
      </option>
    ));
  }

  /**
   * Gets the default value for the dropdown
   * @return {*}
   */
  defaultValue() {
    const {radius, radii} = this.props;

    // if the radius exists in the dropdown
    if (Object.values(radii).indexOf(radius) > -1) {
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
        <div className="field dropdown form-group--no-label">

          <div className="middleColumn">
            <select
              name="radius"
              className="dropdown form-group--no-label"
              defaultValue={this.defaultValue()}
            >
              <option value="">radius</option>
              {this.mappedRadii()}
            </select>
          </div>
        </div>
      );
    }
    return null;
  }
}

RadiusDropDown.propTypes = {
  radius: PropTypes.oneOfType([
    PropTypes.number,
    PropTypes.string,
  ]).isRequired,
  // eslint-disable-next-line react/forbid-prop-types
  radii: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
};

export default RadiusDropDown;
