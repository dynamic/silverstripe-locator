<?php

/**
 * Class LocatorForm
 */
class LocatorForm extends Form
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

        $categories = (Locator::locator_categories_by_locator($controller->data()->ID)->count() > 0)
            ? Locator::locator_categories_by_locator($controller->data()->ID)
            : Locator::get_all_categories();

        $categoriesField = DropdownField::create('CategoryID')
            ->setTitle('')
            ->setEmptyString('All Categories')
            ->setSource($categories->map());

        $fields->push($categoriesField);

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