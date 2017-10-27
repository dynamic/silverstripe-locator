import ActionType from '../../js/actions/ActionTypes';
import * as actions from '../../js/actions/mapActions';

/**
 * Tests to see if what the open marker action returns is valid
 */
test('Open marker action is valid', () => {
  expect(actions.openMarker(1)).toEqual({
    type: ActionType.MARKER_CLICK,
    payload: {
      key: 1,
    },
  });
});

/**
 * Tests to see if what the close marker action returns is valid
 */
test('Close marker action is valid', () => {
  expect(actions.closeMarker(10)).toEqual({
    type: ActionType.MARKER_CLOSE,
    payload: 10,
  });
});

/**
 * Tests to see if what the highlight location action returns is valid
 */
test('Highlight location action is valid', () => {
  expect(actions.highlightLocation(11)).toEqual({
    type: ActionType.MARKER_CLICK,
    payload: 11,
  });
});
