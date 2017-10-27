import React from 'react';
import { shallow } from 'enzyme';

import { Loading, mapStateToProps } from '../../js/components/Loading';

test('Loading component should render', () => {
  const props = {
    isLoading: true,
  };
  const loading = shallow(
    <Loading {...props} />,
  );

  expect(loading.length).toEqual(1);
});

test('Loading component should be showing', () => {
  const props = {
    isLoading: true,
  };
  const loading = shallow(
    <Loading {...props} />,
  );

  expect(loading.hasClass('show')).toEqual(true);
});

test('Loading component should be hiding', () => {
  const props = {
    isLoading: false,
  };
  const loading = shallow(
    <Loading {...props} />,
  );

  expect(loading.children().length).toEqual(0);
  expect(loading.hasClass('show')).toEqual(false);
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
