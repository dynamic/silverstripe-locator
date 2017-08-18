import ActionType from 'actions/ActionTypes';

const defaultState = {
  current: '-1',
  showCurrent: false,
};

export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.MARKER_CLICK:
      return {
        ...state,
        current: action.payload.key,
        showCurrent: true,
      };

    case ActionType.MARKER_CLOSE:
      return {
        ...state,
        showCurrent: false,
      };

    case ActionType.SEARCH:
      return {
        ...state,
        current: '-1',
        showCurrent: false,
      };

    default:
      return state;
  }
}
