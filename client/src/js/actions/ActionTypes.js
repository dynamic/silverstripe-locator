/**
 * List of action types.
 * Could just be strings, but I feel better when referencing a constant that doesn't change without erroring.
 */
const ActionTypes = {
  // Query actions
  QUERY_RESULT: 'APOLLO_QUERY_RESULT',

  // location fetching
  FETCH_LOCATIONS: 'FETCH_LOCATIONS',
  FETCH_LOCATIONS_LOADING: "FETCH_LOCATIONS_LOADING",
  FETCH_LOCATIONS_SUCCESS: "FETCH_LOCATIONS_SUCCESS",
  FETCH_LOCATIONS_ERROR: "FETCH_LOCATIONS_ERROR",

  // Search action
  SEARCH: 'SEARCH',

  // Marker actions
  MARKER_CLICK: 'MARKER_CLICK',
  MARKER_CLOSE: 'MARKER_CLOSE',
};

export default ActionTypes;
