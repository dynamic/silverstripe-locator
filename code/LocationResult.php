<?php

class LocationResult extends DataObject {

	static $db = array(
		'QueryDate' => 'Date'
	);

	static $has_one = array(
		'Location' => 'Location',
		'LocationQuery' => 'LocationQuery'
	);
	
	static $searchable_fields = array(
		'Location.ID' => array(
			'title' => 'Location',
		),
		'LocationQuery.Name' => array(
			'title' => 'Query'
		),
		'LocationQuery.Radius' => array(
			'title' => 'Radius'
		),
		'QueryDate' => array(
			'title' => 'Date'
		)
	);
	
	static $summary_fields = array(
		'Location.Name' => 'Location',
		'LocationQuery.Name' => 'Query',
		'LocationQuery.Radius' => 'Radius',
		'LocationQuery.ID' => 'Query ID',
		'QueryDate' => 'Date'
	);

}