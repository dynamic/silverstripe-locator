import React from 'react';
import PropTypes from 'prop-types';

class RadiusDropDown extends React.Component {
  /**
   * Maps the radii into options for the drop down.
   * @returns {array}
   */
  mappedRadii() {
    return this.props.radii.map(radius =>
      (
        <option
          value={radius}
          key={radius}
        >{radius}</option>
      ),
    );
  }

  /**
   * Outputs the radius drop down.
   * @returns {*}
   */
  render() {
    const { radii } = this.props;
    if (radii !== undefined && radii.length > 0) {
      return (
        <div className="field dropdown form-group--no-label">

          <div className="middleColumn">
            <select
              name="radius"
              className="dropdown form-group--no-label"
              defaultValue=""
            >
              <option value="">radius</option>
              {this.mappedRadii()}
            </select>
          </div>
        </div>
      );
    } else {
      return null;
    }
  }
}

RadiusDropDown.propTypes = {
  // eslint-disable-next-line react/forbid-prop-types
  radii: PropTypes.array.isRequired,
};

export default RadiusDropDown;
