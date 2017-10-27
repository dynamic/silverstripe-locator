import React from 'react';
import { shallow } from 'enzyme';
import { Parser as HtmlToReactParser } from 'html-to-react';

import { MapContainer, mapStateToProps } from '../../../js/components/map/MapContainer';

const dispatch = jest.fn();

// template function - just return what is passed
const template = jest.fn(val => val);

// html to react parser - just return what is passed
HtmlToReactParser.parse = template;

/**
 * Tests if the MapContainer component renders
 */
test('Map container component should render', () => {
  const container = shallow(
    <MapContainer
      dispatch={dispatch}
      current={-1}
      showCurrent={false}
      clusters={false}
      template={() => 'template'}
    />,
  );

  expect(container.length).toEqual(1);
});

/**
 * Tests if the MapContainer component has markers
 */
test('Map container component should have markers', () => {
  const container = shallow(
    <MapContainer
      dispatch={dispatch}
      current={-1}
      showCurrent={false}
      clusters={false}
      template={() => 'template'}
      locations={[
        {
          ID: 1,
          Lat: 45.5163147,
          Lng: 25.3684474,
        },
        {
          ID: 2,
          Lat: -33.955016,
          Lng: 18.424874,
        },
      ]}
    />,
  );

  const markers = container.instance().getMarkers();
  expect(markers.length).toEqual(2);
  expect(markers[0].position).toEqual({
    lat: 45.5163147,
    lng: 25.3684474,
  });
  expect(markers[0].infoContent.props.children).toEqual('template');
});

/**
 * Tests if the MapContainer component handles marker clicks
 */
test('Map container component should handle marker clicks', () => {
  const container = shallow(
    <MapContainer
      dispatch={dispatch}
      current={-1}
      showCurrent={false}
      clusters={false}
      template={() => 'template'}
    />,
  );

  dispatch.mockClear();
  expect(dispatch.mock.calls.length).toEqual(0);
  container.instance().handleMarkerClick(1);
  expect(dispatch.mock.calls.length).toEqual(1);
  dispatch.mockClear();
});

/**
 * Tests if the MapContainer component handles marker closings
 */
test('Map container component should handle marker closings', () => {
  const container = shallow(
    <MapContainer
      dispatch={dispatch}
      current={-1}
      showCurrent={false}
      clusters={false}
      template={() => 'template'}
    />,
  );

  dispatch.mockClear();
  expect(dispatch.mock.calls.length).toEqual(0);
  container.instance().handleMarkerClose(1);
  expect(dispatch.mock.calls.length).toEqual(1);
  dispatch.mockClear();
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
