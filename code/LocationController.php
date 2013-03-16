<?php

class LocationController extends Controller {

	protected $template = "LocationController";
 
	function Link($action = null) {
		return Controller::join_links('LocationController', $action);
	}
	
	

}