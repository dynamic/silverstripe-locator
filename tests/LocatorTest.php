<?php

namespace Dynamic\Locator\Tests;

use Dynamic\Locator\Locator;

use SilverStripe\Forms\FieldList;
use SilverStripe\Dev\FunctionalTest;

/**
 * Class LocatorTest
 */
class LocatorTest extends LocatorTest_Base
{

    /**
     *
     */
    public function testGetCMSFields()
    {
        $locator = singleton(Locator::class);
        $this->assertInstanceOf(FieldList::class, $locator->getCMSFields());
    }
}
