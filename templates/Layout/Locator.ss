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