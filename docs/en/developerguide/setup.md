## Setup
To use google maps an api key is required. 
In mysite/_config/settings.yml
```yaml
Dynamic\SilverStripeGeocoder\GoogleGeocoder:
  geocoder_api_key: YOUR_API_KEY
```
Replace `YOUR_API_KEY` with your google maps api key. If you are unsure where to get an api key, [look here](https://developers.google.com/maps/documentation/javascript/get-api-key).
