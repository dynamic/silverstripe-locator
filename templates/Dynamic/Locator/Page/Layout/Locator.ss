<% require css('dynamic/silverstripe-locator: css/map.css') %>
<% require javascript('https://code.jquery.com/jquery-3.7.1.min.js') %>
<div class="col-sm-9">
    <div class="element-area main-element-area">
        $ElementalArea
    </div>

</div>
<div class="col-sm-12">
    <div class="form-container">
        $LocationSearch
    </div>
</div>
<div class="col-sm-12">
    <% if $getTrigger %>
        <% if $Locations %>
            <div id="map-container" class="row">
                <div id="map" class="col-md-8 order-md-last"></div>
                <div class="loc-list col-md-4 order-md-first">
                    <ul id="list">
                    </ul>
                </div>
            </div>
        <% else %>
            <div id="no-locals">
                <p>No locations match your search criteria. Please refine your search and try again.</p>
            </div>
        <% end_if %>
    <% end_if %>
</div>

<% require javascript('dynamic/silverstripe-locator: thirdparty/jquery-store-locator-plugin/assets/js/libs/handlebars.min.js') %>
<% require javascript('dynamic/silverstripe-locator: thirdparty/jquery-store-locator-plugin/assets/js/plugins/storeLocator/jquery.storelocator.js') %>
