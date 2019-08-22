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
    public function testIndex()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $controller = LocatorController::create($locator);
        $this->assertInstanceOf(ViewableData::class, $controller->index($controller->getRequest()));
    }

    /**
     *
     */
    public function testXml()
    {
        /** @var Locator $locator */
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $page = $this->get($locator->Link('xml'));

        $this->assertEquals(200, $page->getStatusCode());
        $this->assertEquals('application/xml', $page->getHeader('content-type'));

        $dom = new DOMDocument();
        // true if it loads, false if it doesn't
        $valid = $dom->loadXML($page->getBody());
        $this->assertTrue($valid);
    }

    /**
     *
     */
    public function testJson()
    {
        /** @var Locator $locator */
        $locator = $this->objFromFixture(Locator::class, 'locator1');
        $page = $this->get($locator->Link('json'));

        $this->assertEquals(200, $page->getStatusCode());
        $this->assertEquals('application/json', $page->getHeader('content-type'));

        $json = json_decode($page->getBody());
        // if it is null its not valid
        $this->assertNotNull($json);
    }

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
