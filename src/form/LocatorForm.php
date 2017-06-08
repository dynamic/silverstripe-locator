<?php

namespace Dynamic\Locator;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Control\Controller;

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

        if (Config::inst()->get(LocatorForm::class, 'show_radius')) {
            $radiusArray = Config::inst()->get(LocatorForm::class, 'radius_array');
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
     * @return null|RequiredFields|\SilverStripe\Forms\Validator
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