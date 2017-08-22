import React from 'react';
import PropTypes from 'prop-types';
import {
  graphql,
  compose,
} from 'react-apollo';
import { connect } from 'react-redux';

import readLocations from 'queries/readLocations';
import Search from 'components/search/SearchBar';
import MapArea from 'components/map/MapArea';

/**
 * The main locator component.
 */
class Locator extends React.Component {
  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    if (this.props.loadedSettings === false) {
      return <div />;
    }
    return (
      <div>
        <Search />
        <MapArea locations={this.props.data.readLocations} />
      </div>
    );
  }
}

/**
 * The prop types of the Locator component
 * @type {{data}}
 */
Locator.propTypes = {
  data: PropTypes.shape({
    readLocations: PropTypes.object,
  }),
  loadedSettings: PropTypes.bool.isRequired,
};

/**
 * The defaults of props that aren't required
 * @type {{data: {readLocations: {}}}}
 */
Locator.defaultProps = {
  data: {
    readLocations: {},
  },
};

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{address, radius}}
 */
function mapStateToProps(state) {
  return {
    address: state.search.address,
    radius: state.search.radius,
    category: state.search.category,
    unit: state.settings.unit,
    loadedSettings: state.settings.loadedSettings,
  };
}

/**
 * The default export of the file.
 *
 * It is first connected to the redux state, then with graphql.
 * Graphql then uses the props of the component to put variables into a query.
 *
 * State -> Props -> Query
 *
 * Whenever the state is changed the props change and this triggers a new query.
 */
export default compose(
  connect(mapStateToProps),
  graphql(readLocations, {
    skip: ({ loadedSettings }) => !loadedSettings,
    options: ({ address, radius, category, unit }) => ({
      variables: {
        /* eslint-disable object-shorthand */
        address: address,
        radius: radius,
        category: category,
        unit: unit,
        /* eslint-enable */
      },
    }),
  }),
)(Locator);
