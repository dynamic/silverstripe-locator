#Extending

To change how the front-end javascript displays the map the custom script with the unique id `locator_map_init_script`.
This example shows how to reference custom templates and a custom data location. It is recommended to copy the custom script from the [Locator Controller](../../../code/pages/Locator.php#L273-L298) and modify it.

```php
$load = 'autoGeocode: false,  
    fullMapStart: true,';
$kilometer = ($this->owner->data()->Unit == 'km') ? "lengthUnit: 'km'" : "lengthUnit: 'm'";
$modal = ($this->owner->data()->ModalWindow) ? 'modalWindow: true' : 'modalWindow: false';

Requirements::customScript("
    $(function(){
        $('#map-container').storeLocator({
            {$load}
            dataLocation: '{$this->owner->Link()}SimpleXML.xml',
            listTemplatePath: '{$this->listTemplate}',
            infowindowTemplatePath: '{$this->windowTemplate}',
            originMarker: true,
            visibleMarkersList: false,
            storeLimit: -1,
            maxDistance: true,
            slideMap: false,
            distanceAlert: -1,
            {$kilometer},
            {$modal},
            mapID: 'map',
            locationList: 'loc-list',
            mapSettings: {
                zoom: 0,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDoubleClickZoom: false,
                scrollwheel: true,
                navigationControl: false,
                draggable: true
            }
        })
    });",
    "locator_map_init_script");
}
```

Please note that this will replace the script that is loaded.
More options for the javascript map options can be found [here](https://github.com/bjorn2404/jQuery-Store-Locator-Plugin).