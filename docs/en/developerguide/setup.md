## Setup
To use google maps two api keys are required.
One for the client side map, and one for the back end geocoding.
The back end key only needs access to 
In mysite/_config/settings.yml
```yaml
Dynamic\SilverStripeGeocoder\GoogleGeocoder:
  geocoder_api_key: BACK_END_API_KEY
  map_api_key: FRONT_END_API_KEY
```
Replace `BACK_END_API_KEY` with your google maps api key that is restricted by ip.
Replace `FRONT_END_API_KEY` with your google maps api key that is restricted by referrer.

If you are unsure where to get an api key, [look here](https://developers.google.com/maps/documentation/javascript/get-api-key).
