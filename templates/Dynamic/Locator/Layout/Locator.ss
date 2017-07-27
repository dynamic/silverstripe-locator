<div class="content-container unit size3of4 lastUnit">
	<h1>$Title</h1>
	<% if $Content %><div class="typography">$Content</div><% end_if %>
    <div class="form-container">
		$LocationSearch
    </div>
	<% if $getTrigger %>
		<% if $Locations %>
            <div id="map-container">
                <div id="map"></div>
                <div class="loc-list">
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

<% require javascript('locator/client/dist/js/vendor.js') %>
<% require javascript('locator/client/dist/js/main.js') %>
<div class="locator"></div>
