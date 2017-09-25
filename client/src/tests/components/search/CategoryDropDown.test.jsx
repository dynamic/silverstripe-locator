import React from 'react';
import { shallow } from 'enzyme';

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

  expect(dropdown.length).toEqual(1);

  const select = dropdown.find('.form-control');
  expect(select.children().length).toEqual(4);
});


test('Category dropdown component should not render', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category=""
      categories={[]}
    />,
  );

  expect(dropdown.getNode()).toEqual(null);
});

test('Category dropdown default empty value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category=""
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toEqual(1);

  expect(select.prop('defaultValue')).toEqual('');
});

test('Category dropdown default valid value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category="2"
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toEqual(1);

  expect(select.prop('defaultValue')).toEqual('2');
});

test('Category dropdown default invalid value test', () => {
  const dropdown = shallow(
    <CategoryDropDown
      category="99"
      categories={values}
    />,
  );

  const select = dropdown.find('.form-control');
  expect(select.length).toEqual(1);

  expect(select.prop('defaultValue')).toEqual('');
});
