import React from 'react';
import { shallow } from 'enzyme';

import { List, mapStateToProps } from '../../../js/components/list/List';

import * as mock from '../../../js/actions/mapActions';

// list of locations to use
const locations = [
  {
    ID: '1',
    Title: 'Location',
    Address: 'Address 1',
    Address2: 'Address 2',
    City: 'City',
    State: 'State',
    PostalCode: 'Zip',
    Website: 'http://example.com',
    Phone: '123-456-7777',
    Email: 'd@a.g',
    Distance: -1,
    search: false,
    current: true,
  },
  {
    ID: '2',
    Title: 'Location',
    Address: 'Address 1',
    Address2: 'Address 2',
    City: 'City',
    State: 'State',
    PostalCode: 'Zip',
    Website: 'http://example.com',
    Phone: '123-456-7777',
    Email: 'd@a.g',
    Distance: 10,
    search: true,
    current: false,
  },
  {
    ID: '2',
    Title: 'Location',
    Website: 'http://example.com',
    Phone: '123-456-7777',
    Email: 'd@a.g',
    Distance: 10,
    search: true,
    current: false,
  },
];

const template = jest.fn();
const dispatch = jest.fn();
const openMarker = jest.fn();

mock.openMarker = openMarker;
jest.setMock('../../../js/actions/mapActions');

/**
 * Tests to see if the component renders without erroring
 */
test('List component should render', () => {
  const list = shallow(
    <List
      unit="m"
      dispatch={dispatch}
      template={template}
      locations={locations}
    />,
  );

  expect(list.length).toEqual(1);
});

/**
 * tests the map state to props method.
 * Only requires that an object is returned, doesn't matter what is in it.
 */
test('Map state to props', () => {
  const state = {
    search: {},
    map: {},
    settings: {},
    locations: {},
  };
  // expects mapStateToProps to be an Object
  expect(mapStateToProps(state)).toEqual(expect.any(Object));
});
