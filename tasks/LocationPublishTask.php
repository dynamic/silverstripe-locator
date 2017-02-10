<?php

class LocationPublishTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Publish all Locations';
    /**
     * @var string
     */
    protected $description = 'Migration task - pre versioning on Location';
    /**
     * @var bool
     */
    protected $enabled = true;
    /**
     * @param $request
     */
    public function run($request)
    {
        $this->publishLocations();
    }
    /**
     * mark all ProductDetail records as ShowInMenus = 0.
     */
    public function publishLocations()
    {
        $locations = Location::get();
        $ct = 0;
        foreach ($locations as $location) {
            if ($location->ShowInLocator == 1 && !$location->isPublished()) {
                $title = $location->Title;
                $location->writeToStage('Stage');
                $location->publish('Stage', 'Live');
                echo $title.'<br><br>';
                ++$ct;
            }
        }
        echo '<p>'.$ct.' locations updated.</p>';
    }
}