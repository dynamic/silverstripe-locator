import handlebars from 'handlebars';
import ActionType from 'actions/ActionTypes';

const defaultState = {
  loadedSettings: false,
  unit: 'm',
};

/**
 * The reducer for creating a part in the store for things like radius and categories
 */
export default function reducer(state = defaultState, action) {
  switch (action.type) {
    case ActionType.FETCH_SETTINGS_SUCCESS: {
      const settings = action.payload.data;

      // just in case unit is null
      if (settings.unit === null) {
        settings.unit = 'm';
      }

      if (settings.clusters === null) {
        settings.clusters = false;
      }

      return {
        ...state,
        loadedSettings: true,

        unit: settings.unit,
        clusters: settings.clusters,
        limit: settings.limit,
        radii: settings.radii,
        categories: settings.categories,
        infoWindowTemplate: handlebars.compile(settings.infoWindowTemplate),
        listTemplate: handlebars.compile(settings.listTemplate),
      };
    }

    default:
      return state;
  }
}
