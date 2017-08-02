import React from 'react';

class SearchBar extends React.Component {
  mappedRadii() {
    return this.props.radii.map(radius =>
      (
        <option
          value="radius"
          key={radius}
        >{radius}</option>
      ),
    );
  }

  radius() {
    if (this.props.radii !== undefined) {
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

  render() {
    return (
      <form>
        <fieldset>
          <div className="field text form-group--no-label">
            <div className="middleColumn">
              <input
                type="text"
                name="address"
                className="text form-group--no-label"
                required="required"
                aria-required="true"
                placeholder="address or zip code"
              />
            </div>
          </div>

          {this.radius()}
        </fieldset>

        <div className="btn-toolbar">
          <input
            type="submit"
            value="Search"
            className="action"
          />
        </div>
        <div className="clear" />
      </form>
    );
  }
}

export default SearchBar;
