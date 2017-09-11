/* global window */
import axios from 'axios';

import ActionType from 'actions/ActionTypes';

// eslint-disable-next-line import/prefer-default-export
export function fetchSettings() {
  const loc = window.location;
  return (dispatch) => {
    dispatch({
      type: ActionType.FETCH_SETTINGS,
      payload: axios.get(
        `${loc.protocol}//${loc.host}${loc.pathname}/settings`,
      ),
    });
  };
}
