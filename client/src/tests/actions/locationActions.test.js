import axios from 'axios';
import MockAdaptor from 'axios-mock-adapter';

import ActionType from '../../js/actions/ActionTypes';
import * as actions from '../../js/actions/locationActions';

// mocks axios so we can test ajax action stuff
const mock = new MockAdaptor(axios);
mock.onAny().reply(200);

/**
 * Tests to see if what the locations action returns is valid
 */
test('Locations action is valid', () => {
  expect(actions.fetchLocations()).toEqual({
    type: ActionType.FETCH_LOCATIONS,
    payload: new Promise(() => {}),
  });
});
