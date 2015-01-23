[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-locator/v/stable.svg)](https://packagist.org/packages/dynamic/silverstripe-locator) [![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-locator/downloads.svg)](https://packagist.org/packages/dynamic/silverstripe-locator) [![Latest Unstable Version](https://poser.pugx.org/dynamic/silverstripe-locator/v/unstable.svg)](https://packagist.org/packages/dynamic/silverstripe-locator) [![License](https://poser.pugx.org/dynamic/silverstripe-locator/license.svg)](https://packagist.org/packages/dynamic/silverstripe-locator)
[![Code Climate](https://codeclimate.com/github/dynamic/SilverStripe-Locator-Module/badges/gpa.svg)](https://codeclimate.com/github/dynamic/SilverStripe-Locator-Module)

Overview
=================================

 The Locator module displays a searchable map of locations. You can choose whether to show all locations on load, or enable auto geocoding to filter the initial list based on the visitor's location. 

Composer Installation
=================================

`"require": { "dynamic/silverstripe-locator": "dev-master }`

Add `locator` and `addressable` to your `.gitignore`

Git Installation
=================================

`git clone git@github.com:dynamic/SilverStripe-Locator-Module.git locator`

`git clone git@github.com:ajshort/silverstripe-addressable.git addressable`

`rm -rf .git` (optional, to remove existing git repo)

Requirements
=================================

 *  SilverStripe 3.1.x
 *  Addressable Module by ajshort for Location geocoding - https://github.com/ajshort/silverstripe-addressable
 
Use
=================================

 Create a Locator page in the CMS. Locations are managed under the Locations tab in the CMS via Model Admin. Simply enter the name and address of each location, and they will appear on the map.

 ~~To customise locations with custom fields, do as you normally would using a DataExtension. Then copy LocationXML.ss, infowindow-description.html and location-list-description.html into your theme's template folder.
 You can add new fields from the DataExtension to the LocationXML.ss to access them in the two .html templates. (i.e. `<marker newField="$newField.XML">` and in the html templates `{{newField}}`)~~

Maintainer Contact
=================================

 *  Dynamic (<info@dynamicdoes.com>)

Links
=================================

 * [SilverStripe Addressable](https://github.com/ajshort/silverstripe-addressable) by Andrew Short
 * [jQuery Store Locator Plugin](https://github.com/bjorn2404/jQuery-Store-Locator-Plugin)
 * [SilverStripe CMS](http://www.silverstripe.org/)

License
=================================

	Copyright (c) 2013, Dynamic Inc
	All rights reserved.

	Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

	Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
	
	Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
	
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
