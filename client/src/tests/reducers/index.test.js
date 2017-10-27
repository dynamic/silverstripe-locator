import reducer from '../../../src/js/reducers/index';

/**
 * Tests the reducer
 */
test('Tests the reducer to make sure its a function', () => {
  expect(reducer.constructor).toEqual(Function);
});
