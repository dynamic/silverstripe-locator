import ActionType from 'actions/ActionTypes';

const defaultState = {
  locations: [],
};

export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.FETCH_LOCATIONS_SUCCESS:
      return {
        ...state,
        locations: action.payload.data.locations,
      };

    default:
      return state;
  }
}
