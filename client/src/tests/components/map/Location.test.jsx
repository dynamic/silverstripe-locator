import React from 'react';
import { shallow } from 'enzyme';
import toJson from 'enzyme-to-json';

import Location from '../../../js/components/list/Location';

const location = {
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
  distance: '0',
};

test('Location component should render test', () => {
  const component = shallow(<Location location={location} index={1} current={'1'} search="" />);
  expect(toJson(component).type).toBe('li');
});

test('Location component\'s address 2 should render test', () => {
  const component = shallow(<Location location={location} index={1} current={'1'} search="" />);
  const address2 = component.find('.loc-addr2');
  expect(address2.length).toBe(1);
  expect(address2.node.props.children).toBe(location.Address2);
  // TODO - add location without address
});
