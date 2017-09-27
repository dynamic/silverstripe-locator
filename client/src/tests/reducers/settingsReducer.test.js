import handlebars from 'handlebars';

import ActionType from '../../../src/js/actions/ActionTypes';
import reducer from '../../../src/js/reducers/settingsReducer';

const compile = jest.fn();
compile.mockReturnValue('template');

// setup fetchLocations to use mock function (so it can be checked against later)
handlebars.compile = compile;
jest.setMock('handlebars', handlebars);

/**
 * Tests the default state
 */
test('Settings reducer has a default state', () => {
  expect(reducer(undefined, {
    type: 'invalid-type',
  })).toEqual({
    loadedSettings: false,
    unit: 'm',
  });
});

/**
 * Tests FETCH_SETTINGS_SUCCESS with everything is defined
 */
test('Settings reducer has a valid state when everything is defined', () => {
  expect(reducer(undefined, {
    type: ActionType.FETCH_SETTINGS_SUCCESS,
    payload: {
      data: {
        unit: 'm',
        clusters: false,
        limit: 0,
        radii: [],
        categories: [],
        infoWindowTemplate: '',
        listTemplate: '',
      },
    },
  })).toEqual({
    loadedSettings: true,
    unit: 'm',
    clusters: false,
    limit: 0,
    radii: [],
    categories: [],
    infoWindowTemplate: 'template',
    listTemplate: 'template',
  });
});

/**
 * Tests FETCH_SETTINGS_SUCCESS with some stuff is undefined
 */
test('Settings reducer has a valid state when some stuff is undefined', () => {
  expect(reducer(undefined, {
    type: ActionType.FETCH_SETTINGS_SUCCESS,
    payload: {
      data: {
        unit: null,
        clusters: null,
        limit: 0,
        radii: [],
        categories: [],
        infoWindowTemplate: '',
        listTemplate: '',
      },
    },
  })).toEqual({
    loadedSettings: true,
    unit: 'm',
    clusters: false,
    limit: 0,
    radii: [],
    categories: [],
    infoWindowTemplate: 'template',
    listTemplate: 'template',
  });
});

