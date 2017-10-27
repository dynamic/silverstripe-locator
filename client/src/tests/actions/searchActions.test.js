import ActionType from '../../js/actions/ActionTypes';
import * as actions from '../../js/actions/searchActions';

/**
 * Tests to see if what the search action returns is valid
 */
test('Search action is valid', () => {
  // tests an empty search
  expect(actions.search()).toEqual({
    type: ActionType.SEARCH,
    payload: {},
  });

  // tests a filled out search
  expect(actions.search({
    a: 'a',
    b: 'b',
  })).toEqual({
    type: ActionType.SEARCH,
    payload: {
      a: 'a',
      b: 'b',
    },
  });
});
