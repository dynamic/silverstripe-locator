<?php

namespace Dynamic\Locator\Tests\Form;

use Dynamic\Locator\Model\Location;
use Dynamic\Locator\Page\Locator;
use Dynamic\Locator\Page\LocatorController;
use Dynamic\Locator\Form\LocatorForm;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;

/**
 * Class LocatorFormTest
 * @package Dynamic\Locator\Tests\Form
 */
class LocatorFormTest extends FunctionalTest
{
    protected static $fixture_file = 'locatorformfixture.yml';

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        Config::modify()->set(Locator::class, 'location_class', Location::class);
    }

    /**
     *
     */
    public function testLocatorFormBase()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $form = LocatorForm::create(LocatorController::create($locator), 'LocatorForm');

        $this->assertInstanceOf(FieldList::class, $form->Fields());
        $this->assertInstanceOf(RequiredFields::class, $form->getValidator());
    }

    /**
     *
     */
    public function testUpdateRequiredFields()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $form = LocatorForm::create(LocatorController::create($locator), 'LocatorForm');
        $validator = $form->getValidator();

        $validator->removeRequiredField('Address');
        $validator->addRequiredField('Foo');

        $this->assertEquals(['Foo'], $form->getValidator()->getRequired());
    }

    /**
     *
     */
    public function testFields()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $form = LocatorForm::create(LocatorController::create($locator), 'LocatorForm');
        $this->assertInstanceOf(FieldList::class, $form->Fields());
    }

    /**
     *
     */
    public function testActions()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $form = LocatorForm::create(LocatorController::create($locator), 'LocatorForm');
        $this->assertInstanceOf(FieldList::class, $form->Actions());
    }
}
