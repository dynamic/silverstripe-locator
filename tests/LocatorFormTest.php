<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Locator;
use Dynamic\Locator\LocatorController;
use Dynamic\Locator\LocatorForm;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;

class LocatorFormTest extends FunctionalTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'fixtures.yml';

    /**
     *
     */
    public function testLocatorFormBase()
    {
        $form = LocatorForm::create(LocatorController::create(Locator::get()->first()), 'LocatorForm');

        $this->assertInstanceOf(FieldList::class, $form->Fields());
        $this->assertInstanceOf(RequiredFields::class, $form->getValidator());
    }

    /**
     *
     */
    public function testUpdateRequiredFields()
    {
        $form = LocatorForm::create(LocatorController::create(Locator::get()->first()), 'LocatorForm');
        $validator = $form->getValidator();

        $validator->removeRequiredField('Address');
        $validator->addRequiredField('Foo');

        $this->assertEquals(['Foo'], $form->getValidator()->getRequired());
    }

}