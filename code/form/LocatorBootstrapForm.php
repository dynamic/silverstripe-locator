<?php

if (class_exists('BootstrapForm')) {

    /**
     * Class LocatorForm
     */
    class LocatorBootstrapForm extends BootstrapForm
    {

        /**
         * LocatorForm constructor.
         * @param Controller $controller
         * @param string $name
         */
        public function __construct(Controller $controller, $name)
        {

            $fields = FieldList::create(
                TextField::create('Address')
                    ->setTitle('')
                    ->setAttribute('placeholder', 'address or zip code')
            );

            if (LocationCategory::get()->count() > 0) {
                $categories = DropdownField::create('CategoryID')
                    ->setTitle('')
                    ->setEmptyString('All Categories')
                    ->setSource(LocationCategory::get()->map());
                $fields->push($categories);
            }

            $this->extend('updateLocatorFormFields', $fields);

            $actions = FieldList::create(
                FormAction::create('doFilterLocations')
                    ->setTitle('Search')
            );

            $this->extend('updateLocatorFormActions', $actions);

            $validator = RequiredFields::create();

            $this->extend('updateLocatorFormRequiredFields', $validator);

            parent::__construct($controller, $name, $fields, $actions, $validator);
        }

    }

}