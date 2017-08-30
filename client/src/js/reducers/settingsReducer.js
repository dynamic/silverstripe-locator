import handlebars from 'handlebars';
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
      let settings = action.result.data.locatorSettings;

      // skip if no settings attached
      if (settings === undefined) {
        return state;
      }

      // in case its an array
      if (settings.constructor === Array) {
        settings = settings[0];
      }

      // just in case unit is null
      if (settings.Unit === null) {
        settings.Unit = 'm';
      }

      if (settings.Clusters === null) {
        settings.Clusters = 'false';
      }

      return {
        ...state,
        loadedSettings: true,

        unit: settings.Unit,
        clusters: settings.Clusters,
        limit: settings.Limit,
        radii: JSON.parse(settings.Radii),
        categories: JSON.parse(settings.Categories),
        infoWindowTemplate: handlebars.compile(JSON.parse(settings.InfoWindowTemplate)),
        listTemplate: handlebars.compile(JSON.parse(settings.ListTemplate)),
      };
    }

    default:
      return state;
  }
}
