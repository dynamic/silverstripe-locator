<div class="content-container unit size3of4 lastUnit">
	<h1>$Title</h1>
	<% if $Content %><div class="typography">$Content</div><% end_if %>
	<% if $Locations %>
        <p>$Locations.Count locations</p>
		<div id="form-container">
			$LocationSearch
		</div>

		<div id="map-container">
			<div id="map"></div>
			<div id="loc-list">
				<ul id="list">
					<li><img src="locator/images/ajax-loader.gif" class="loading"></li>
				</ul>
			</div>
		</div>
	<% else %>
        <div id="no-locals">
            <p>No locations match your search criteria. Please refine your search and try again.</p>
        </div>
	<% end_if %>
</div>
<% require javascript('locator/thirdparty/jQuery-Store-Locator-Plugin-2.6.2/dist/assets/js/libs/handlebars.min.js') %>
<% require javascript("locator/thirdparty/jQuery-Store-Locator-Plugin-2.6.2/dist/assets/js/plugins/storeLocator/jquery.storelocator.min.js") %>
<% require javascript("https://maps.google.com/maps/api/js?key=AIzaSyDIQEXXYYK3-lKNubgT3m7HjHsyahp_Xz4") %>
<script type="text/javascript">
$(function(){
    $('#map-container').storeLocator({
        autoGeocode: false,
		fullMapStart: true,
		storeLimit: 1000,
		maxDistance: true,
        dataLocation: '/locator/xml.xml',
        listTemplatePath: 'locator/templates/location-list-description.html',
        infowindowTemplatePath: 'locator/templates/infowindow-description.html',
        originMarker: true,
        modalWindow: false,
        featuredLocations: true,
        slideMap: false,
        zoomLevel: 0,
        noForm: true,
        formID: 'LocatorForm_LocationSearch',
        distanceAlert: -1,
        lengthUnit: "m"
    });
});
</script>