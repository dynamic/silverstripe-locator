import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import { fetchLocations } from 'actions/locationActions';
import { fetchSettings } from 'actions/settingsActions';

import Search from 'components/search/SearchBar';
import MapContainer from 'components/map/MapContainer';
import List from 'components/list/List';
import Loading from 'components/Loading';

/**
 * The main locator component.
 */
export class Locator extends Component {
  /**
   * Called before the component mounts
   */
  componentWillMount() {
    const { dispatch } = this.props;
    dispatch(fetchSettings());
  }

  /**
   * Should this component update
   * @param nextProps
   * @return {boolean}
   */
  shouldComponentUpdate(nextProps) {
    const { loadedSettings } = this.props;
    return (loadedSettings !== nextProps.loadedSettings);
  }

  /**
   * Called before the component updates
   * @param nextProps
   */
  componentWillUpdate(nextProps) {
    const { dispatch, unit, address, radius, category } = nextProps;
    dispatch(fetchLocations({
      unit,
      address,
      radius,
      category,
    }));
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
        <div className="map-area">
          <MapContainer />
          <List />
          <Loading />
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
  unit: PropTypes.string.isRequired,
  address: PropTypes.string.isRequired,
  radius: PropTypes.oneOfType([
    PropTypes.number,
    PropTypes.string,
  ]).isRequired,
  category: PropTypes.string.isRequired,
  dispatch: PropTypes.func.isRequired,
};

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{loadedSettings}}
 */
export function mapStateToProps(state) {
  return {
    loadedSettings: state.settings.loadedSettings,

    unit: state.settings.unit,
    address: state.search.address,
    radius: state.search.radius,
    category: state.search.category,
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
