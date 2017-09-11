import {
  combineReducers,
} from 'redux';

import searchReducer from 'reducers/searchReducer';
import mapReducer from 'reducers/mapReducer';
import settingsReducer from 'reducers/settingsReducer';
import locationReducer from 'reducers/locationReducer';

const reducers = combineReducers({
  search: searchReducer,
  map: mapReducer,
  settings: settingsReducer,
  locations: locationReducer,
});

export default reducers;
