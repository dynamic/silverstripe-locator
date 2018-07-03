<?php

namespace Dynamic\Locator\Tests\Control;

use DOMDocument;
use Dynamic\Locator\Control\APIController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\View\ViewableData;

/**
 * Class APIControllerTest
 * @package Dynamic\Locator\Tests\Control
 */
class APIControllerTest extends FunctionalTest
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
        $controller = APIController::create();
        $this->assertInstanceOf(ViewableData::class, $controller->index($controller->getRequest()));
    }

    /**
     *
     */
    public function testXml()
    {
        /** @var APIController $controller */
        $controller = APIController::create();
        $page = $this->get($controller->Link('xml'));

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
        /** @var APIController $controller */
        $controller = APIController::create();
        $page = $this->get($controller->Link('json'));

        $this->assertEquals(200, $page->getStatusCode());
        $this->assertEquals('application/json', $page->getHeader('content-type'));

        $json = json_decode($page->getBody());
        // if it is null its not valid
        $this->assertNotNull($json);
    }

    /**
     *
     */
    public function testGetFilter()
    {
        /** @var APIController $controller */
        $controller = APIController::create();
        $this->assertEquals(array(), $controller->getFilter($this->createRequest()));

        $this->assertEquals(array(
            'Categories.ID' => '1',
        ), $controller->getFilter($this->createRequest(array(
            'CategoryID' => '1',
        ))));
    }

    /**
     *
     */
    public function testGetFilterAny()
    {
        /** @var APIController $controller */
        $controller = APIController::create();
        $request = $this->createRequest();

        $this->assertEquals(array(), $controller->getFilterAny($request));

        $controller->config()->update('base_filter_any', array(
            'Any' => 'one',
        ));

        $this->assertEquals(array(
            'Any' => 'one',
        ), $controller->getFilterAny($request));
    }

    /**
     *
     */
    public function testGetExclude()
    {
        /** @var APIController $controller */
        $controller = APIController::create();
        $request = $this->createRequest();

        $this->assertEquals(array(
            'Lat' => 0,
            'Lng' => 0,
        ), $controller->getExclude($request));

        $controller->config()->update('base_exclude', array(
            'Any' => 'one',
        ));

        $this->assertEquals(array(
            'Any' => 'one',
            'Lat' => 0,
            'Lng' => 0,
        ), $controller->getExclude($request));
    }

    /**
     *
     */
    public function testGetLimit()
    {
        /** @var APIController $controller */
        $controller = APIController::create();

        $this->assertEquals(50, $controller->getLimit($this->createRequest()));

        $this->assertEquals(50, $controller->getLimit(
            $this->createRequest(array(
                'Limit' => 109,
            ))
        ));

        $this->assertEquals(25, $controller->getLimit(
            $this->createRequest(array(
                'Limit' => 25,
            ))
        ));
    }

    /**
     * @param array $getVars
     * @return \SilverStripe\Control\HTTPRequest
     */
    private function createRequest($getVars = array())
    {
        $link = APIController::create()->Link();

        $request = new HTTPRequest('GET', $link, $getVars);
        $session = new Session([]);
        $request->setSession($session);

        return $request;
    }
}
