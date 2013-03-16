<?php
class LocationImportController extends Controller {
	protected $template = "LocationImportController";
 
	function Link($action = null) {
		return Controller::join_links('LocationImportController', $action);
	}
 
	function Form() {
		$form = new Form(
			$this,
			'Form',
			new FieldSet(
				new FileField('CsvFile', false)
			),
			new FieldSet(
				new FormAction('doUpload', 'Upload')
			),
			new RequiredFields()
		);
		return $form;
	}
 
	function doUpload($data, $form) {
		$loader = new LocationCsvBulkLoader('Dealer');
		$loader->deleteExistingRecords = true;
		$results = $loader->load($_FILES['CsvFile']['tmp_name']);
		//debug::show($results);
		$messages = array();
		if($results->CreatedCount()) $messages[] = sprintf('Imported %d items', $results->CreatedCount());
		if($results->UpdatedCount()) $messages[] = sprintf('Updated %d items', $results->UpdatedCount());
		if($results->DeletedCount()) $messages[] = sprintf('Deleted %d items', $results->DeletedCount());
		if(!$messages) $messages[] = 'No changes';
		$form->sessionMessage(implode(', ', $messages), 'good');
 
		return $this->redirectBack();
	}
}