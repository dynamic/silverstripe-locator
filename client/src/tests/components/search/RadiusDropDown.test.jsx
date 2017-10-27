import React from 'react';
import { shallow } from 'enzyme';

import RadiusDropDown from '../../../js/components/search/RadiusDropDown';

const radii = {
  0: 2,
  1: 4,
  2: 8,
  3: 16,
};

test('Radius dropdown component should render', () => {
  const dropdown = shallow(
    <RadiusDropDown
      radius={-1}
      radii={radii}
      unit="m"
    />,
  );

  expect(dropdown.length).toEqual(1);

  const select = dropdown.find('.form-control');
  expect(select.children().length).toEqual(5);
});

test('Radius dropdown component should not render', () => {
  const dropdown = shallow(
    <RadiusDropDown
      radius={-1}
      radii={[]}
      unit="m"
    />,
  );

  expect(dropdown.getNode()).toEqual(null);
});

test('Radius dropdown default valid value test', () => {
  const dropdown = shallow(
    <RadiusDropDown
      radius={16}
      radii={radii}
      unit="m"
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toEqual(1);

  expect(select.prop('defaultValue')).toEqual(16);
});

test('Radius dropdown default invalid value test', () => {
  const dropdown = shallow(
    <RadiusDropDown
      radius={-1}
      radii={radii}
      unit="m"
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toEqual(1);

  expect(select.prop('defaultValue')).toEqual('');
});
