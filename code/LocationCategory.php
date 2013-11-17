<?php

class LocationCategory extends DataObject {
	
	static $db = array(
		'Name' => 'Varchar(100)'
	);
	
	static $has_many = array(
		'Locations' => 'Location'
	);
	
	public static $singular_name = "Category";
	public static $plural_name = "Categories";
	
}