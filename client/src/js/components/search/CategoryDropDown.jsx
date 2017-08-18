import React from 'react';
import PropTypes from 'prop-types';

class CategoryDropDown extends React.Component {
  /**
   * Maps the radii into options for the drop down.
   * @returns {Array}
   */
  mappedCategories() {
    const { categories } = this.props;

    return Object.keys(categories).map(key => (
      <option
        value={key}
        key={key}
      >
        {categories[key]}
      </option>
    ));
  }

  /**
   * Outputs the radius drop down.
   * @returns {*}
   */
  render() {
    const { categories } = this.props;
    if (categories !== undefined && Object.keys(categories).length !== 0) {
      return (
        <div className="field dropdown form-group--no-label">
          <div className="middleColumn">
            <select
              name="category"
              className="dropdown form-group--no-label"
              defaultValue=""
            >
              <option value="">category</option>
              {this.mappedCategories()}
            </select>
          </div>
        </div>
      );
    }
    return null;
  }
}

CategoryDropDown.propTypes = {
  // eslint-disable-next-line react/forbid-prop-types
  categories: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
};

export default CategoryDropDown;
