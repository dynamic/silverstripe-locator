import gql from 'graphql-tag';

/**
 * The query for getting locations
 */
export default gql`
  query($address: String, $radius: String, $category: String, $unit: String){
    readLocations(address: $address, radius: $radius, category: $category, unit: $unit) {
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
          distance
          Category {
            ID
            Name
          }
        }
      } 
    }
  }
`;
