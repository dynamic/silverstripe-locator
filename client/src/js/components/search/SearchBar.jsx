/* global window, document */
import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { fetchLocations } from 'actions/locationActions';
import RadiusDropDown from 'components/search/RadiusDropDown';
import CategoryDropDown from 'components/search/CategoryDropDown';

export class SearchBar extends Component {
  /**
   * Turns a javascript object into url params.
   * Skips keys without values
   *
   * @param obj
   * @return {string}
   */
  static objToUrl(obj) {
    let vars = '';

    Object.keys(obj).forEach((key) => {
      const value = obj[key];

      // don't add it if its blank
      if (value !== undefined && value !== null && value !== '') {
        vars += `${key}=${value}&`;
      }
    });

    // replaces trailing spaces and '&' symbols then replaces spaces with +
    return vars.replace(/([&\s]+$)/g, '').replace(/(\s)/g, '+');
  }

  /**
   * Used to create the SearchBar.
   * needed to allow use of this keyword in handler.
   * @param props
   */
  constructor(props) {
    super(props);
    this.handleSubmit = this.handleSubmit.bind(this);
  }


  /**
   * 'Submits' form. Really just fires state change and changes the url.
   */
  handleSubmit(event) {
    event.preventDefault();
    const addressInput = document.getElementsByName('address')[0].value;
    const radiusInput = document.getElementsByName('radius')[0].value;

    // because categories are optional
    let categoryInput = '';
    if (document.getElementsByName('category')[0] !== undefined) {
      categoryInput = document.getElementsByName('category')[0].value;
    }

    const params = {
      address: addressInput,
      radius: radiusInput,
      category: categoryInput,
    };

    // selects dispatch and unit from this.props.
    // const dispatch = this.props.dispatch; const unit = this.props.unit;
    const { dispatch, unit } = this.props;
    dispatch(
      fetchLocations({
        ...params,
        unit,
      }),
    );

    // changes the url for the window and adds it to the browser history(no redirect)
    const loc = window.location;
    const newurl = `${loc.protocol}//${loc.host}${loc.pathname}?${SearchBar.objToUrl(params)}`;
    window.history.pushState({
      path: newurl,
    }, '', newurl);
  }

  /**
   * Renders the component.
   * @returns {XML}
   */
  render() {
    const { address, category, radii, categories, unit } = this.props;
    let { radius } = this.props;
    if (typeof radius === 'string') {
      radius = Number(radius);
    }
    return (
      <form onSubmit={this.handleSubmit} className="locator-search">
        {/* not a fieldset because no flexbox */}
        <div className="fieldset">
          <div className="address-input form-group">
            <label htmlFor="address" className="sr-only">Address or zip code</label>
            <input
              type="text"
              name="address"
              className="form-control"
              placeholder="address or zip code"
              defaultValue={address}
            />
          </div>
          <RadiusDropDown radii={radii} radius={radius} unit={unit} />
          <CategoryDropDown categories={categories} category={category} />
        </div>

        <div className="fieldset actions">
          <div className="form-group">
            <input
              type="submit"
              value="Search"
              className="btn"
            />
          </div>
        </div>
      </form>
    );
  }
}

SearchBar.propTypes = {
  address: PropTypes.string.isRequired,
  radius: PropTypes.oneOfType([
    PropTypes.number,
    PropTypes.string,
  ]).isRequired,
  category: PropTypes.string.isRequired,

  // eslint-disable-next-line react/forbid-prop-types
  radii: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
  // eslint-disable-next-line react/forbid-prop-types
  categories: PropTypes.oneOfType([
    PropTypes.object,
    PropTypes.array,
  ]).isRequired,
  unit: PropTypes.string.isRequired,
  dispatch: PropTypes.func.isRequired,
};

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{address, radius}}
 */
export function mapStateToProps(state) {
  return {
    // the defaults - for when it gets loaded from the url
    address: state.search.address,
    radius: state.search.radius,
    category: state.search.category,

    // the options
    radii: state.settings.radii,
    categories: state.settings.categories,

    // other
    unit: state.settings.unit,
  };
}

export default connect(mapStateToProps)(SearchBar);
