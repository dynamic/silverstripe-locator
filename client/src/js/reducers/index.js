import {
  combineReducers,
} from 'redux';


export default function reducers(client) {
  return combineReducers({
    client: client.reducer(),
  });
}
