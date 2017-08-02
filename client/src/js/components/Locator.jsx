import React from 'react';
import PropTypes from 'prop-types';
import {
  graphql,
  compose,
} from 'react-apollo';
import { connect } from 'react-redux';

import readLocations from '../queries/readLocations';
import Search from './search/SearchBar';
import Map from './Map';

/**
 * The main locator component.
 */
class Locator extends React.Component {
  /**
   * Renders the component
   * @returns {XML}
   */
  render() {
    const radii = [
      25, 50, 75, 100,
    ];
    return (
      <div>
        <Search radii={radii} />
        <Map locations={this.props.data.readLocations} />
      </div>
    );
  }
}

/**
 * Takes variables/functions from the state and assigns them to variables/functions in the components props.
 *
 * @param state
 * @returns {{address, radius}}
 */
function mapStateToProps(state) {
  return {
    address: state.client.address,
    radius: state.client.radius,
  };
}

/**
 * The default export of the file.
 *
 * It is first connected to the redux state, then with graphql.
 * Graphql then uses the state to put variables into a query.
 */
export default compose(
  connect(mapStateToProps),
  graphql(readLocations, {
    options: ({ address, radius }) => ({
      variables: {
        address,
        radius,
      },
    }),
  }),
)(Locator);
