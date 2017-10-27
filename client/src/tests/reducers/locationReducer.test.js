import ActionType from '../../../src/js/actions/ActionTypes';
import reducer from '../../../src/js/reducers/locationReducer';

/**
 * Tests the default state
 */
test('Location reducer has a default state', () => {
  expect(reducer(undefined, {
    type: 'invalid-type',
  })).toEqual({
    locations: [],
  });
});

/**
 * Tests the FETCH_LOCATIONS_SUCCESS state
 */
test('Location reducer has a valid success state', () => {
  expect(reducer(undefined, {
    type: ActionType.FETCH_LOCATIONS_SUCCESS,
    payload: {
      data: {
        locations: [
          'a',
          'b',
          'c',
        ],
      },
    },
  })).toEqual({
    locations: [
      'a',
      'b',
      'c',
    ],
  });
});

