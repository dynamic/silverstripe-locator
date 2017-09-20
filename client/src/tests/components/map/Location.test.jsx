import React from 'react';
import handlebars from 'handlebars';
import { shallow } from 'enzyme';
import toJson from 'enzyme-to-json';

import Location from '../../../js/components/list/Location';

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
    Distance: 0,
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

const templateString = `
    <div className="list-label">{{Number}}</div>
    <div className="list-details">
      <div className="list-content">
        <div className="loc-name">{{{Title}}}</div>
        <div className="loc-addr">{{{Address}}}</div>
        <div className="loc-addr2">{{{Address2}}}</div>
        <div className="loc-addr3">{{{City}}}, {{{State}}} {{{PostalCode}}}</div>
        <div className="loc-phone">{{{Phone}}}</div>
        <div className="loc-web"><a href={{{Website}}} target="_blank">Website</a></div>
        <div className="loc-email"><a href="mailto:{{{Email}}}">Email</a></div>
        <div className="loc-dist">{{Distance}}</div>
        <div className="loc-directions">{{{DirectionsLink}}}</div>
      </div>
    </div>
 `;

const template = handlebars.compile(templateString);

const unit = 'm';

const mockOnClick = jest.fn();

const locationComponents = locations.map(
  (loc, index) =>
    shallow(
      <Location
        location={locations[index]}
        index={index}
        template={template}
        unit={unit}
        onClick={mockOnClick}
        style={{
          backgroundColor: 'white',
        }}
        current={loc.current}
        search={loc.search}
      />,
    ),
);

test('Location component should render test', () => {
  expect(toJson(locationComponents[0]).type).toBe('div');

  const address2 = locationComponents[0].find('.loc-addr2');
  expect(address2.length).toBe(1);
  expect(address2.node.props.children).toBe('Address 2');
});

test('Location component\'s distance', () => {
  let distance = locationComponents[0].find('.loc-dist');
  expect(distance.length).toBe(1);
  expect(distance.node.props.children).toBe('false');

  distance = locationComponents[1].find('.loc-dist');
  expect(distance.length).toBe(1);
  expect(distance.node.props.children).toBe('10.00');
});

test('Location component\'s directions', () => {
  let daddr = locationComponents[0].find('.loc-directions');
  expect(daddr.length).toBe(1);
  expect(daddr.node.props.children)
    .toBe('http://maps.google.com/maps?saddr=&daddr=Address+1+Address+2+City+State+Zip');

  daddr = locationComponents[2].find('.loc-directions');
  expect(daddr.length).toBe(1);
  expect(daddr.node.props.children)
    .toBe('http://maps.google.com/maps?saddr=&daddr=');
});

test('Location\'s onClick call', () => {
  locationComponents[0].simulate('click');
  expect(mockOnClick).toBeCalledWith('1');
});
