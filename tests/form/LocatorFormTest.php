<?php

namespace Dynamic\Locator\Tests\Form;

use Dynamic\Locator\Page\Locator;
use Dynamic\Locator\Page\LocatorController;
use Dynamic\Locator\Form\LocatorForm;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;

/**
 * Class LocatorFormTest
 * @package Dynamic\Locator\Tests\Form
 */
class LocatorFormTest extends FunctionalTest
{
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

    /**
     *
     */
    public function testFields()
    {
        $form = LocatorForm::create(LocatorController::create(Locator::get()->first()), 'LocatorForm');
        $this->assertInstanceOf(FieldList::class, $form->Fields());
    }

    /**
     *
     */
    public function testActions()
    {
        $form = LocatorForm::create(LocatorController::create(Locator::get()->first()), 'LocatorForm');
        $this->assertInstanceOf(FieldList::class, $form->Actions());
    }
}
