<?php

namespace Dynamic\Locator\Tests;

use \DOMDocument;
use Dynamic\Locator\LocationCategory;
use Dynamic\Locator\Locator;
use Dynamic\Locator\LocatorController;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\View\ViewableData;

/**
 * Class LocatorControllerTest
 * @package Dynamic\Locator\Tests
 */
class LocatorControllerTest extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     * @var bool
     */
    protected static $use_draft_site = true;

    /**
     *
     */
    public function testLocationSearch()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $object = LocatorController::create($locator);
        $form = $object->LocationSearch();
        $this->assertInstanceOf(Form::class, $form);

        $category = $this->objFromFixture(LocationCategory::class, 'service');
        $category2 = $this->objFromFixture(LocationCategory::class, 'manufacturing');
        $locator->Categories()->add($category);
        $locator->Categories()->add($category2);

        $form = $object->LocationSearch();
        $fields = $form->Fields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

}
