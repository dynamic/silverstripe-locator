import gql from 'graphql-tag';

/**
 * The query for getting locations
 */
export default gql`
  query {
    readLocations {
      edges {
        node {
          ID
          Title
          Website
          Email
          Phone
          Address
          Address2
          City
          State
          Country
          PostalCode
          Lat
          Lng
        }
      } 
    }
  }
`;
