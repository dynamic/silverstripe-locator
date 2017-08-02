/* global document */
import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { search } from '../../actions/searchActions';
import RadiusDropDown from './RadiusDropDown';

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

    this.props.dispatch(
      search({
        address: addressInput,
        radius: radiusInput,
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
                required="required"
                aria-required="true"
                placeholder="address or zip code"
              />
            </div>
          </div>
          <RadiusDropDown radii={this.props.radii} />
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
  radii: PropTypes.array.isRequired,
  dispatch: PropTypes.func.isRequired,
};

export default connect()(SearchBar);
