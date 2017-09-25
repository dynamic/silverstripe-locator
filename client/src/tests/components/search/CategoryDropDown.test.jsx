import React from 'react';
import { shallow } from 'enzyme';
import toJson from 'enzyme-to-json';

import CategoryDropDown from '../../../js/components/search/CategoryDropDown';

const values = [
  {
    ID: 1,
    Name: 'one',
  },
  {
    ID: 2,
    Name: 'two',
  },
  {
    ID: 3,
    Name: 'three',
  },
];

test('Category dropdown component should render', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category="2"
      categories={values}
    />,
  );
  expect(toJson(dropdown).type).toBe('div');

  const select = dropdown.find('.form-control');
  expect(select.length).toBe(1);

  const children = select.node.props.children;
  expect(children.length).toBe(2);
  expect(children[1].length).toBe(3);
});


test('Category dropdown component should not render', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category=""
      categories={[]}
    />,
  );

  expect(toJson(dropdown)).toBe(null);
});

test('Category dropdown default empty value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category=""
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toBe(1);

  const props = select.node.props;
  expect(props.defaultValue).toBe('');
});

test('Category dropdown default valid value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category="2"
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toBe(1);

  const props = select.node.props;
  expect(props.defaultValue).toBe('2');
});

test('Category dropdown default invalid value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category="99"
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toBe(1);

  const props = select.node.props;
  expect(props.defaultValue).toBe('');
});
