# SilverStripe Locator

[![Build Status](https://travis-ci.org/dynamic/silverstripe-locator.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-locator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-locator/build-status/master)
[![codecov.io](https://codecov.io/github/dynamic/silverstripe-locator/coverage.svg?branch=master)](https://codecov.io/github/dynamic/silverstripe-locator?branch=master)

SilverStripe Locator displays a filterable map of locations. You can choose whether to show all locations on load, or enable auto geocoding to filter the initial list based on the visitor's location. 

## Requirements

 *  SilverStripe 3.1.x or higher
 *  [Addressable Module](https://github.com/silverstripe-australia/silverstripe-addressable) by for location geocoding

## Installation

`composer require "dynamic/silverstripe-locator" "dev-master"`

Add `locator` and `addressable` to your `.gitignore`

## Example usage

Displays a filterable list of locations on a map. Users can filter by address or category to find the location nearest them. 

With auto geocoding enabled in the CMS, the map will display the nearest 26 locations to the user.

![screen shot](images/Locator.png)
 
## Documentation

See the [docs/en](docs/en/index.md) folder.

## Maintainer Contact

 *  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)