/* global window */
import axios from 'axios';

import ActionType from 'actions/ActionTypes';

// eslint-disable-next-line import/prefer-default-export
export function fetchLocations() {
  const loc = window.location;
  return (dispatch) => {
    dispatch({
      type: ActionType.FETCH_LOCATIONS,
      payload: axios.get(
        `${loc.protocol}//${loc.host}${loc.pathname}json`,
      ),
    });
  };
}
