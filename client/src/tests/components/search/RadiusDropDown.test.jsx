import React from 'react';
import { shallow } from 'enzyme';
import toJson from 'enzyme-to-json';

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

  expect(toJson(dropdown).type).toBe('div');

  const select = dropdown.find('.form-control');
  expect(select.length).toBe(1);

  const children = select.node.props.children;
  expect(children.length).toBe(2);
  expect(children[1].length).toBe(4);
});

test('Radius dropdown component should not render', () => {
  const dropdown = shallow(
    <RadiusDropDown
      radius={-1}
      radii={[]}
      unit="m"
    />,
  );

  expect(toJson(dropdown)).toBe(null);
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
  expect(select.length).toBe(1);

  const props = select.node.props;
  expect(props.defaultValue).toBe(16);
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
  expect(select.length).toBe(1);

  const props = select.node.props;
  expect(props.defaultValue).toBe('');
});
