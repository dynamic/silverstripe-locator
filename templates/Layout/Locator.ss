<div class="content-container unit size3of4 lastUnit">
	<h1>$Title</h1>
	<% if $Content %><div class="typography">$Content</div><% end_if %>
	<% if $Locations %>
        <p>$Locations.Count locations</p>
		<div id="form-container">
			$LocationSearch
		</div>

		<div id="bh-sl-map-container" class="bh-sl-map-container">
			<div class="row">
				<div id="map-results-container" class="container">
					<div id="bh-sl-map" class="bh-sl-map col-md-9"></div>
					<div class="bh-sl-loc-list col-md-3">
						<ul class="list list-unstyled"></ul>
					</div>
				</div>
			</div>
		</div>
	<% else %>
        <div id="no-locals">
            <p>No locations match your search criteria. Please refine your search and try again.</p>
        </div>
	<% end_if %>
</div>