import {
  combineReducers,
} from 'redux';

import searchReducer from 'reducers/searchReducer';
import mapReducer from 'reducers/mapReducer';

export default function reducers(client) {
  return combineReducers({
    client: client.reducer(),
    search: searchReducer,
    map: mapReducer,
  });
}
