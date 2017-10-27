import ActionType from '../../../src/js/actions/ActionTypes';
import reducer from '../../../src/js/reducers/searchReducer';

/**
 * Tests the default state
 */
test('Search reducer has a default state', () => {
  expect(reducer(undefined, {
    type: 'invalid-type',
  })).toEqual({
    address: '',
    radius: -1,
    category: '',
  });
});

/**
 * Tests the SEARCH state
 */
test('Search reducer has a valid search state', () => {
  expect(reducer(undefined, {
    type: ActionType.SEARCH,
    payload: {
      address: 'test',
      radius: 25,
      category: '5',
    },
  })).toEqual({
    address: 'test',
    radius: 25,
    category: '5',
  });
});
