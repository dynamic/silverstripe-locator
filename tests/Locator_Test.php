<?php

namespace Dynamic\Locator\Tests;

use SilverStripe\Dev\FunctionalTest;

/**
 * Class Locator_Test
 */
class Locator_Test extends FunctionalTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'locator/tests/Locator_Test.yml';
    /**
     * @var bool
     */
    protected static $disable_themes = true;
    /**
     * @var bool
     */
    protected static $use_draft_site = false;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    }

    /**
     *
     */
    public function logOut()
    {
        $this->session()->clear('loggedInAs');
        $this->session()->clear('logInWithPermission');
    }

    /**
     *
     */
    public function testLocator_Test()
    {
    }

}
