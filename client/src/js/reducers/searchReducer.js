import ActionType from '../actions/ActionTypes';

const defaultState = {
  address: '',
  radius: '',
};

export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.SEARCH:
      return {
        ...state,
        address: action.payload.address,
        radius: action.payload.radius,
      };

    default:
      return state;
  }
}
