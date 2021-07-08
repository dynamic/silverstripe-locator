## Extending
The locator has some custom extension points.

### LocatorForm
#### updateLocatorFormFields(FieldList $fields)
Used to update the fields of the locator form.
Passed the current FieldList of the form.

#### updateRequiredFields(Validator $validator)
Used to update the required fields of the locator form.
Passed the current Validator of the form.

### LocatorController
#### overrideRadiusArray(array $radii)
Used to update or replace the radii used to make the radius dropdown.

#### updateLocatorFilter(array $filter, HTTPRequest $request)
Used to update the filters used on the location list when `setLocations()` is called.
Passed the array of current filters and the current HTTPRequest.

### updateLocatorFilterAny(array $filterAny, HTTPRequest $request)
Used to update the filter anys used on the location list when `setLocations()` is called.
Passed the array of current filter anys and the current HTTPRequest.

### updateLocatorExclude(array $exclude, HTTPRequest $request)
Used to update the excludes used on the location list when `setLocations()` is called.
Passed the array of current excludes and the current HTTPRequest.

### updateLocationList(ArrayList $locations)
Used to update the location list when `setLocations()` is called.
Passed the current list of locations after filters and excludes have been applied, but before distance has been applied.

### updateListType(ArrayList $locations)
Used to update the location list's type when `setLocations()` is called.
Passed the current list of locations after filters, excludes, and distance have been applied and `updateLocationList()` has been run.
