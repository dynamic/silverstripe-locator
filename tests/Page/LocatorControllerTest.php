<?php

namespace Dynamic\Locator\Tests\Page;

use Dynamic\Locator\Model\Location;
use Dynamic\Locator\Model\LocationCategory;
use Dynamic\Locator\Page\Locator;
use Dynamic\Locator\Page\LocatorController;
use Dynamic\Locator\Tests\TestOnly\Extension\LocatorControllerExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\View\ViewableData;
use SilverStripe\View\Requirements;

/**
 * Class LocatorControllerTest
 * @package Dynamic\Locator\Tests
 */
class LocatorControllerTest extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'locatorcontrollerfixture.yml';

    /**
     * @var bool
     */
    protected static $use_draft_site = true;

    /**
     * @var array
     */
    protected static $required_extensions = [
        LocatorController::class => [
            LocatorControllerExtension::class,
        ],
    ];

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

        $dom = new \DOMDocument();
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

    /**
     *
     */
    public function testMapSettingsDistanceUnits()
    {
        $locator = $this->objFromFixture(Locator::class, 'locator1');

        $locator->Unit = 'm';
        $locator->write();
        $mapSettings = $this->getMapSettings($locator);

        $this->assertSame('m', $mapSettings['lengthUnit']);
        $this->assertSame('mi', $mapSettings['mileLang']);
        $this->assertSame('mi', $mapSettings['milesLang']);

        $locator->Unit = 'km';
        $locator->write();
        $mapSettings = $this->getMapSettings($locator);

        $this->assertSame('km', $mapSettings['lengthUnit']);
        $this->assertSame('km', $mapSettings['kilometerLang']);
        $this->assertSame('km', $mapSettings['kilometersLang']);
    }

    /**
     * @param Locator $locator
     *
     * @return array
     */
    private function getMapSettings(Locator $locator)
    {
        LocatorControllerExtension::$mapSettings = [];
        Requirements::clear();

        $controller = LocatorController::create($locator);
        $request = new HTTPRequest('GET', $locator->Link());
        $request->setSession(new Session([]));
        $controller->setRequest($request);
        $controller->pushCurrent();

        try {
            $controller->doInit();
        } finally {
            $controller->popCurrent();
            Requirements::clear();
        }

        return LocatorControllerExtension::$mapSettings;
    }
}
