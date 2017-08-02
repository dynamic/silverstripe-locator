import gql from 'graphql-tag';

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
