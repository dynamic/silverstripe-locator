/**
 * List of action types.
 * Could just be strings, but I feel better when referencing a constant that doesn't change without erroring.
 */
const ActionTypes = {
  // location fetching
  FETCH_LOCATIONS: 'FETCH_LOCATIONS',

  // settings fetching
  FETCH_SETTINGS: 'FETCH_SETTINGS',

  // Search action
  SEARCH: 'SEARCH',

  // Marker actions
  MARKER_CLICK: 'MARKER_CLICK',
  MARKER_CLOSE: 'MARKER_CLOSE',
};

// uses the base FETCH_LOCATIONS to construct resulting actions (can't do this in the actual const)
ActionTypes.FETCH_LOCATIONS_LOADING = `${ActionTypes.FETCH_LOCATIONS}_LOADING`;
ActionTypes.FETCH_LOCATIONS_SUCCESS = `${ActionTypes.FETCH_LOCATIONS}_SUCCESS`;
ActionTypes.FETCH_LOCATIONS_ERROR = `${ActionTypes.FETCH_LOCATIONS}_ERROR`;

// uses the base FETCH_SETTINGS to construct resulting actions (can't do this in the actual const)
ActionTypes.FETCH_SETTINGS_LOADING = `${ActionTypes.FETCH_SETTINGS}_LOADING`;
ActionTypes.FETCH_SETTINGS_SUCCESS = `${ActionTypes.FETCH_SETTINGS}_SUCCESS`;
ActionTypes.FETCH_SETTINGS_ERROR = `${ActionTypes.FETCH_SETTINGS}_ERROR`;

export default ActionTypes;
