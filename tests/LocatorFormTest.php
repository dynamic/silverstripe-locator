<?php

class LocatorFormTest extends FunctionalTest
{

    public function testLocatorFormBase()
    {
        $form = LocatorForm::create(Locator_Controller::create(Locator::get()->first()), 'LocatorForm');

        $this->assertInstanceOf('FieldList', $form->Fields());
        $this->assertInstanceOf('RequiredFields', $form->getValidator());
    }

    public function testUpdateRequiredFields()
    {
        $form = LocatorFormExtendedForm::create(Locator_Controller::create(Locator::get()->first()), 'LocatorForm');

        $this->assertEquals(['Foo'], $form->getValidator()->getRequired());
    }

}

class LocatorFormTestFormExtension extends Extension implements TestOnly
{
    public function updateRequiredFields(RequiredFields $validator)
    {
        $validator->removeRequiredField('Address');
        $validator->addRequiredField('Foo');
    }
}

class LocatorFormExtendedForm extends LocatorForm implements TestOnly
{

    private static $extensions = [
        'LocatorFormTestFormExtension',
    ];

}