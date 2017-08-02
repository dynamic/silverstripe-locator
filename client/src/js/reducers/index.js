import {
  combineReducers,
} from 'redux';
import searchReducer from './searchReducer';

export default function reducers(client) {
  return combineReducers({
    client: client.reducer(),
    search: searchReducer,
  });
}
