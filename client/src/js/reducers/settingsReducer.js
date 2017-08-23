import ActionType from 'actions/ActionTypes';

const defaultState = {
  loadedSettings: false,
};

/**
 * The reducer for creating a part in the store for things like radius and categories
 */
export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.QUERY_RESULT: {
      const settings = action.result.data.locatorSettings;

      // skip if no settings attached
      if (settings === undefined) {
        return state;
      }
      return {
        ...state,
        loadedSettings: true,

        unit: settings.Unit,
        limit: settings.Limit,
        radii: JSON.parse(settings.Radii),
        categories: JSON.parse(settings.Categories),
        infoWindowTemplate: JSON.parse(settings.InfoWindowTemplate),
      };
    }

    default:
      return state;
  }
}
