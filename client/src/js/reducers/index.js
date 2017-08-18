import {
  combineReducers,
} from 'redux';

import searchReducer from 'reducers/searchReducer';
import mapReducer from 'reducers/mapReducer';
import settingsReducer from 'reducers/settingsReducer';

export default function reducers(client) {
  return combineReducers({
    client: client.reducer(),
    search: searchReducer,
    map: mapReducer,
    settings: settingsReducer,
  });
}
