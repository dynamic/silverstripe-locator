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

        $pageCategories = Locator::locator_categories_by_locator($controller->data()->ID);
        if ($pageCategories && $pageCategories->count() > 0) {
            $categories = false;
        } else {
            $categories = Locator::get_all_categories();
        }

        if ($categories) {
            $categoriesField = DropdownField::create('CategoryID')
                ->setTitle('')
                ->setEmptyString('All Categories')
                ->setSource($categories->map());
            $fields->push($categoriesField);
        }

        $actions = FieldList::create(
            FormAction::create('doFilterLocations')
                ->setTitle('Search')
        );

        $validator = RequiredFields::create();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

}