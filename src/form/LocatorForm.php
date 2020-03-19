<?php

namespace Dynamic\Locator\Form;

use Dynamic\Locator\Page\Locator;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\ArrayLib;

/**
 * Class LocatorForm
 * @package Dynamic\Locator\Form
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
            if ($categories->count() < 1) {
                $categories = false;
            }
        }

        if ($categories) {
            $categoriesField = DropdownField::create('CategoryID')
                ->setTitle('')
                ->setEmptyString('all categories')
                ->setSource($categories->map());
            $fields->push($categoriesField);
        }

        if ($controller->getShowRadius()) {
            $radiusArray = array_values($controller->getRadii());
            $this->extend('overrideRadiusArray', $radiusArray);
            $fields->push(DropdownField::create('Radius', '', ArrayLib::valuekey($radiusArray))
                ->setEmptyString('radius'));
        }

        $actions = FieldList::create(
            FormAction::create('doFilterLocations')
                ->setTitle('Search')
        );

        $validator = $this->getValidator();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

    /**
     * @return null|RequiredFields|\SilverStripe\Forms\Validator
     */
    public function getValidator()
    {
        $validator = parent::getValidator();
        if (empty($validator)) {
            if (!$this->validator instanceof RequiredFields) {
                $this->setValidator(RequiredFields::create('Address'));
            }
            $validator = $this->validator;
        }
        $this->extend('updateRequiredFields', $validator);
        return $validator;
    }

    /**
     * @return FieldList
     */
    public function Fields()
    {
        $fields = parent::Fields();
        $this->extend('updateLocatorFormFields', $fields);
        return $fields;
    }

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function Actions()
    {
        $actions = parent::Actions();
        $this->extend('updateLocatorActions', $actions);
        return $actions;
    }
}
