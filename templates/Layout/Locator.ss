<div class="content-container unit size3of4 lastUnit">
	<h1>$Title</h1>
	<% if $Content %><div class="typography">$Content</div><% end_if %>
	<% if $AreLocations %>
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
		</div>
	<% else %>
        <div id="no-locals">
            <h3>Sorry, there are no locations at this time. Please check back later.</h3>
        </div>
	<% end_if %>
</div>


