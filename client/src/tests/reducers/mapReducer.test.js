import ActionType from '../../../src/js/actions/ActionTypes';
import reducer from '../../../src/js/reducers/mapReducer';

/**
 * Tests the default state
 */
test('Map reducer has a default state', () => {
  expect(reducer(undefined, {
    type: 'invalid-type',
  })).toEqual({
    current: -1,
    showCurrent: false,
    isLoading: true,
  });
});

/**
 * Tests the MARKER_CLICK state
 */
test('Map reducer has a valid clicked state', () => {
  expect(reducer(undefined, {
    type: ActionType.MARKER_CLICK,
    payload: {
      key: 1,
    },
  })).toEqual({
    current: 1,
    isLoading: true,
    showCurrent: true,
  });
});

/**
 * Tests the MARKER_CLICK state
 */
test('Location reducer has a valid closed state', () => {
  expect(reducer({
    current: 1,
  }, {
    type: ActionType.MARKER_CLOSE,
  })).toEqual({
    current: 1,
    showCurrent: false,
  });
});

/**
 * Tests the SEARCH state
 */
test('Location reducer has a valid search state', () => {
  expect(reducer(undefined, {
    type: ActionType.SEARCH,
  })).toEqual({
    current: -1,
    showCurrent: false,
    isLoading: true,
  });
});

/**
 * Tests the FETCH_LOCATIONS_LOADING state
 */
test('Location reducer has a valid loading state', () => {
  expect(reducer({
    current: -1,
    showCurrent: false,
    isLoading: false,
  }, {
    type: ActionType.FETCH_LOCATIONS_LOADING,
  })).toEqual({
    current: -1,
    showCurrent: false,
    isLoading: true,
  });
});

/**
 * Tests the FETCH_LOCATIONS_SUCCESS state
 */
test('Location reducer has a valid success state', () => {
  expect(reducer(undefined, {
    type: ActionType.FETCH_LOCATIONS_SUCCESS,
  })).toEqual({
    current: -1,
    showCurrent: false,
    isLoading: false,
  });
});
