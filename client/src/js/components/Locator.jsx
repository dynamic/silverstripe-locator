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
  }).isRequired,
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
    options: ({ address, radius, category }) => ({
      variables: {
        /* eslint-disable object-shorthand */
        address: address,
        radius: radius,
        category: category,
        /* eslint-enable */
      },
    }),
  }),
)(Locator);
