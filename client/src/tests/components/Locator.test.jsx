import React from 'react';
import { shallow } from 'enzyme';

import { Locator, mapStateToProps } from '../../js/components/Locator';

import Search from '../../js/components/search/SearchBar';
import MapContainer from '../../js/components/map/MapContainer';
import List from '../../js/components/list/List';
import Loading from '../../js/components/Loading';

const dispatch = jest.fn();

test('Locator component should render', () => {
  const props = {
    loadedSettings: true,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  const locator = shallow(
    <Locator {...props} />,
  );

  expect(locator.length).toEqual(1);
  // make sure we have everything we need
  expect(locator.find(Search).length).toEqual(1);
  expect(locator.find(MapContainer).length).toEqual(1);
  expect(locator.find(List).length).toEqual(1);
  expect(locator.find(Loading).length).toEqual(1);
});

test('Locator component should not render', () => {
  const props = {
    loadedSettings: false,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  const locator = shallow(
    <Locator {...props} />,
  );

  expect(locator.getNode()).toEqual(null);
});

test('Locator component should update', () => {
  const props = {
    loadedSettings: false,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  const locator = shallow(
    <Locator {...props} />,
  );

  let nextProps = {
    loadedSettings: false,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  let shouldUpdate = locator.instance().shouldComponentUpdate(nextProps);
  expect(shouldUpdate).toEqual(false);


  nextProps = {
    loadedSettings: true,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  shouldUpdate = locator.instance().shouldComponentUpdate(nextProps);
  expect(shouldUpdate).toEqual(true);
});

test('Locator component will update', () => {
  const props = {
    loadedSettings: false,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    dispatch,
  };
  const locator = shallow(
    <Locator {...props} />,
  );

  locator.setProps({
    loadedSettings: true,
  });

  expect(dispatch).toBeCalled();
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
