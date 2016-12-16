<?php

namespace Dynamic\Locator;

use SilverStripe\Forms\Form,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\TextField,
    SilverStripe\Forms\DropdownField,
    SilverStripe\Forms\FormAction,
    SilverStripe\Forms\RequiredFields,
    SilverStripe\Control\Controller;

/**
 * Class LocatorForm
 */
class LocatorForm extends Form
{
    /**
     * @var bool
     */
    private static $show_radius = true;

    /**
     * @var array
     */
    private static $radius_array = [
        '25' => '25',
        '50' => '50',
        '75' => '75',
        '100' => '100',
    ];

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
                ->setEmptyString('all categories')
                ->setSource($categories->map());
            $fields->push($categoriesField);
        }

        if (Config::inst()->get('LocatorForm', 'show_radius')) {
            $radiusArray = Config::inst()->get('LocatorForm', 'radius_array');
            $this->extend('overrideRadiusArray', $radiusArray);
            $fields->push(DropdownField::create('Radius', '', $radiusArray)
                ->setEmptyString('radius')
            );
        }

        $actions = FieldList::create(
            FormAction::create('doFilterLocations')
                ->setTitle('Search')
        );

        $validator = $this->getValidator();

        parent::__construct($controller, $name, $fields, $actions, $validator);
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        $validator = parent::getValidator();
        if (empty($validator)) {
            if (!$this->validator instanceof RequiredFields) $this->setValidator(RequiredFields::create('Address'));
            $validator = $this->validator;
        }
        $this->extend('updateRequiredFields', $validator);
        return $validator;
    }

}