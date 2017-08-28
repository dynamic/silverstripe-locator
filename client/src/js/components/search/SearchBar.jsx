/* global document */
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { search } from 'actions/searchActions';
import RadiusDropDown from 'components/search/RadiusDropDown';
import CategoryDropDown from 'components/search/CategoryDropDown';

class SearchBar extends React.Component {
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
   * 'Submits' form. Really just fires state change.
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

    this.props.dispatch(
      search({
        address: addressInput,
        radius: radiusInput,
        category: categoryInput,
      }),
    );
  }

  /**
   * Renders the component.
   * @returns {XML}
   */
  render() {
    return (
      <form action="" onSubmit={this.handleSubmit}>
        <fieldset>
          <div className="field text form-group--no-label">
            <div className="middleColumn">
              <input
                type="text"
                name="address"
                className="text form-group--no-label"
                aria-required="true"
                placeholder="address or zip code"
              />
            </div>
          </div>
          <RadiusDropDown radii={this.props.radii} />
          <CategoryDropDown categories={this.props.categories} />
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

SearchBar.propTypes = {
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
  dispatch: PropTypes.func.isRequired,
};

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{address, radius}}
 */
function mapStateToProps(state) {
  return {
    radii: state.settings.radii,
    categories: state.settings.categories,
  };
}

export default connect(mapStateToProps)(SearchBar);
