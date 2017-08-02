import ActionType from './ActionTypes';

// eslint-disable-next-line import/prefer-default-export
export function search(inputs) {
  return {
    type: ActionType.SEARCH,
    payload: inputs,
  };
}
