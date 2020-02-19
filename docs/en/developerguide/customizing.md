## Customizing

### YAML Configuration
Some customization is done through a yml config.

#### Limit
Will limit the amount of locations that can be shown at one time. Set to `-1` to have no limit. Having no limit can result in slow load times, or even timeouts when loading the page or new data.
```yaml
Dynamic\Locator\Locator:
  limit: 50
```

#### Radius
- `show_radius` will determine if a radius dropdown should be shown.
- `radii` is a list of radii to use in the radius dropdown.
```yaml
Dynamic\Locator\Locator:
  show_radius: true
  radii: [30, 50, 100]
```

#### Templates
Overriding the templates for the info window and list can be overridden by using `infoWindowTemplate` and `listTemplate`.
- `infoWindowTemplate` is the popup when a location is clicked.
- `listTemplate` is a single location in the list
```yaml
Dynamic\Locator\Locator:
  infoWindowTemplate: 'dynamic/silverstripe-locator: client/infowindow-description.html'
  listTemplate: 'dynamic/silverstripe-locator: client/location-list-description.html'
```
The `vendor/module: file` pattern can be used to locate files.
  
#### Custom URL Variables
Sometimes it is useful to override the defaults for url variables. 
An example of this is when the module uses title case but you wrote everything for lowercase. It becomes seamless to switch out the variable names.
- `radius_var` is the variable used to send and receive the currently selected radius.
- `category_var` is the variable used to send and receive the currently selected category.
- `address_var` is the variable used to send and receive the searched location.
- `unit_var` is the variable used to send and receive the current unit of measure used for distance.
```yaml
Dynamic\Locator\Locator:
  radius_var: 'Radius'
  category_var: 'CategoryID'
  
Dynamic\SilverStripeGeocoder\DistanceDataExtension:
  address_var: 'Address'
  unit_var: 'Unit'
```

### Extenison Points

#### Locator Form
##### overrideRadiusArray
Allows radius array to be changed outside of the yml config.
`overrideRadiusArray` gets passed the radius array.

##### updateRequiredFields
Alolows the required fields to be modified.
`updateRequiredFields` gets passed a Validator object.

##### updateLocatorFormFields
Allows form fields to be modified.
`updateLocatorFormFields` gets passed a field list.

##### updateLocatorActions
Allows form actions to be modified.
`updateLocatorActions` gets passed a field list.

#### Locator Admin
##### updateGetExportFields
Allows exported fields to be modified.
`updateGetExportFields` gets passed an associative array.

#### Location
##### updateLocationFields
Allows cms fields to be modified.
`updateLocationFields` gets passed a field list.

##### updateWebsiteURL
Allows modifying the wesite url of the location.
`updateWebsiteURL` gets passed the website url.

#### Locator Controller
##### modifyMapSettings
Allows modifying the map settings used for the locator javascript.
`modifyMapSettings` gets passed an associative array.

##### modifyMapSettingsEncoded
Allows modifying the map settings after it is turned into a string.
It is prefered to use the `modifyMapSettings` extension point.
`modifyMapSettingsEncoded` gets passed a string.

##### updateLocatorFilter
Allows updating the location list filter.
`updateLocatorFilter` gets passed the current filter and the current request.

##### updateLocatorFilterAny
Allows updating the location list filter any.
`updateLocatorFilterAny` gets passed the current filter any and the current request.

##### updateLocatorExclude
Allows updating the location list exlude.
`updateLocatorFilterAny` gets passed the current exlude and the current request.

##### updateLocationList
Allows updating the list of locations after distance calculations have been done.
`updateLocationList` is passed an array list.

##### updateListType
Allows updating the location list type.
`updateListType` is passed an array list.
