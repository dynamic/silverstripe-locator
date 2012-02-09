
	<h2>$Title</h2>
	<% if Content %><div class="typography">$Content</div><% end_if %>
	
	Address: <input type="text" id="addressInput" size="80" /> &nbsp;&nbsp;
	<input type="button" class="action" onclick="findMe()" value="Find Me"> &nbsp;&nbsp;
    Radius: <select id="radiusSelect">

      <option value="25" selected>25 miles</option>
      <option value="50">50 miles</option>
      <option value="100">100 miles</option>
      <option value="1000">All</option>

    </select>
	&nbsp;&nbsp;
    <input type="button" class="action" onclick="searchLocations()" value="Search"/>
    <br/>    
    <br/>
    <div id="MapDisplay">
      <div id="largeMap"></div>
	  <div id="sidebar"></div>
	  <div id="map"></div>
	</div>


<div class="clear"></div>

