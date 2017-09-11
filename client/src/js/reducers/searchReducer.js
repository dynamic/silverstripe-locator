/* global window */
import ActionType from 'actions/ActionTypes';
import url from 'url';

const defaultState = Object.assign({
  address: '',
  radius: -1,
  category: '',
}, url.parse(window.location.href, true).query);

export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.SEARCH:
      return {
        ...state,
        address: action.payload.address,
        radius: action.payload.radius,
        category: action.payload.category,
      };

    default:
      return state;
  }
}
