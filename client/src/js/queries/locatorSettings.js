import gql from 'graphql-tag';

/**
 * The query for getting locations
 */
export default gql`
  query {
    locatorSettings {
      Limit,
      Radii
    }
  }
`;
