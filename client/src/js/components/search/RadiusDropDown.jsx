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
              defaultValue=""
            >
              <option value="">radius</option>
              {this.mappedRadii()}
            </select>
          </div>
        </div>
      );
    // eslint-disable-next-line no-else-return
    } else {
      return null;
    }
  }
}

RadiusDropDown.propTypes = {
  // eslint-disable-next-line react/forbid-prop-types
  radii: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
};

export default RadiusDropDown;
