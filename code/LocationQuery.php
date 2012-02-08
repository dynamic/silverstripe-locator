<?php

class LocationQuery extends DataObject {

	static $db = array(
		'Name' => 'Varchar(255)',
		'Radius' => 'Int',
		'QueryDate' => 'Date'
	);
	
	static $has_many = array(
		'LocationResults' => 'LocationResult'
	);
	
	static $searchable_fields = array(
		'Name' => array(
			'title' =>  'Query'
		),
		'Radius',
		'QueryDate' => array(
			'title' => 'Date'
		)
	);
	
	static $summary_fields = array(
		'Name',
		'Radius',
		'QueryDate' => 'Date'
	);

}

?>