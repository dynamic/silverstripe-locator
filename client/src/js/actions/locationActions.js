/* global window */
import axios from 'axios';

import ActionType from 'actions/ActionTypes';

// eslint-disable-next-line import/prefer-default-export
export function fetchLocations(params) {
  const loc = window.location;
  return {
    type: ActionType.FETCH_LOCATIONS,
    payload: axios.get(
      `${loc.protocol}//${loc.host}${loc.pathname}/json`,
      {
        // same as "params: params"
        params,
      },
    ),
  };
}
