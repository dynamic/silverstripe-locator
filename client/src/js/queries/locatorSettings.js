import gql from 'graphql-tag';

/**
 * The query for getting the locator settings
 */
export default gql`
  query ($id: Int!){
    locatorSettings (ID: $id){
      Limit,
      Radii,
      Unit,
      Categories
    }
  }
`;
