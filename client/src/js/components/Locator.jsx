import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { fetchLocations } from 'actions/locationActions';

import Search from 'components/search/SearchBar';
import MapContainer from 'components/map/MapContainer';
import List from 'components/list/List';

/**
 * The main locator component.
 */
class Locator extends Component {
  /**
   * Called before the component mounts
   */
  componentWillMount() {
    const { dispatch } = this.props;
    dispatch(fetchLocations());
  }

  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    const { loadedSettings } = this.props;
    if (loadedSettings === false) {
      return <div />;
    }
    return (
      <div>
        <Search />
        <div id="map-area">
          <MapContainer />
          <List />
        </div>
      </div>
    );
  }
}

/**
 * The prop types of the Locator component
 * @type {{data}}
 */
Locator.propTypes = {
  loadedSettings: PropTypes.bool.isRequired,
  dispatch: PropTypes.func.isRequired,
};

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{loadedSettings}}
 */
function mapStateToProps(state) {
  return {
    loadedSettings: state.settings.loadedSettings,
  };
}

/**
 * The default export of the file.
 *
 * The component is connected to the redux state
 *
 * Whenever the state is changed the props change.
 */
export default connect(mapStateToProps)(Locator);
