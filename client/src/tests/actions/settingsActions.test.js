import axios from 'axios';
import MockAdaptor from 'axios-mock-adapter';

import ActionType from '../../js/actions/ActionTypes';
import * as actions from '../../js/actions/settingsActions';

// mocks axios so we can test ajax action stuff
const mock = new MockAdaptor(axios);
mock.onAny().reply(200);

/**
 * Tests to see if what the settings action returns is valid
 */
test('Settings action is valid', () => {
  expect(actions.fetchSettings()).toEqual({
    type: ActionType.FETCH_SETTINGS,
    payload: new Promise(() => {}),
  });
});
