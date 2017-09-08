/* global window, document */
import React from 'react';
import ReactDom from 'react-dom';

import {
  createStore,
  applyMiddleware,
  compose,
} from 'redux';
import thunk from 'redux-thunk';
import promise from 'redux-promise-middleware';

import ApolloClient, { createNetworkInterface } from 'apollo-client';
import { ApolloProvider } from 'react-apollo';

import allReducers from 'reducers';
import Locator from 'components/Locator';
import locatorSettings from 'queries/locatorSettings';

// only the first container is used, can change to querySelectorAll() for multiple instances
const container = document.querySelector('.locator');

// creates the apollo client used to run graphql queries
const client = new ApolloClient({
  networkInterface: createNetworkInterface({
    uri: container.dataset.apiUrl,
    opts: {
      credentials: 'same-origin',
    },
  }),
  // changes the name of where the client stores information in the state
  reduxRootSelector: state => state.client,
});

/**
 * Writes deeply nested function transformations without the rightward drift of the code.
 * [redux compose]{@link http://redux.js.org/docs/api/compose.html}
 * @returns {Function}
 */
function composedMiddleware() {
  return compose(
    applyMiddleware(client.middleware(), promise({
      // new suffixes
      promiseTypeSuffixes: ['LOADING', 'SUCCESS', 'ERROR'],
    }), thunk),
    // eslint-disable-next-line no-underscore-dangle
    (typeof window.__REDUX_DEVTOOLS_EXTENSION__ !== 'undefined') ? window.__REDUX_DEVTOOLS_EXTENSION__() : f => f,
  );
}

// creates the redux store with reducers and middleware
const store = createStore(allReducers(client), composedMiddleware());

// renders the locator, wrapped in an apollo provider so graphql can run queries
ReactDom.render(
  <ApolloProvider store={store} client={client}>
    <Locator />
  </ApolloProvider>
  , container);

// query for settings
client.query({
  query: locatorSettings,
  variables: {
    id: container.dataset.locatorId,
  },
});
