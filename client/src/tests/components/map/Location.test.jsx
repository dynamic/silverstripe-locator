import React from 'react';
import { shallow } from 'enzyme';
import toJson from 'enzyme-to-json';

import Location from '../../../js/components/map/Location';

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
  console.log(toJson(component));
  // TODO - expect(something).toBe(expected);
});
