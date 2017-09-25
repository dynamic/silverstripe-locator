import React from 'react';
import { shallow } from 'enzyme';

import { Locator, mapStateToProps } from '../../js/components/Locator';

const dispatch = jest.fn();

test('LoadingComponent component should render', () => {
  const props = {
    loadedSettings: false,
    unit: 'm',
    address: '',
    radius: '',
    category: '',
    // eslint-disable-next-line object-shorthand
    dispatch: dispatch,
  };
  const loading = shallow(
    <Locator {...props} />,
  );

  expect(loading.length).toEqual(1);
});


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
