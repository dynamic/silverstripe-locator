import ActionType from 'actions/ActionTypes';

// eslint-disable-next-line import/prefer-default-export
export function search(inputs) {
  return {
    type: ActionType.SEARCH,
    payload: inputs,
  };
}
