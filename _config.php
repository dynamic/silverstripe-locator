<?php
	//Location::set_map_key('ABQIAAAAw2DgbrMlBrYJfi9yCZozUhTuTrGhvNI2H61w3srX-7tL8fbvWRSqgsrSvLYtuq7kSf26IzYbySkh6Q');
if (class_exists(Addressable)) {
	object::add_extension('Location', 'Addressable');
	object::add_extension('Location', 'Geocodable');
}