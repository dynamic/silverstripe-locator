<div class="content-container unit size3of4 lastUnit">
	<h2>$Title</h2>
	<% if Content %><div class="typography">$Content</div><% end_if %>
	
	<div id="form-container">
	    <form id="user-location" method="post" action="#">
	        <div id="form-input">
	          	<label for="address">Enter Address or Zip Code:</label>
	          	<input type="text" id="address" name="address" />
	         </div>
	        
	         <div id="submit-btn">
	         	<input type="image" id="submit" name="submit" src="/locator/javascript/jQuery-Store-Locator-Plugin/images/submit.jpg" alt="Submit" />
	         </div>
	    </form>
	</div>
</div>

<div id="map-container">
	<aside class="sidebar unit size1of4">
		<div id="loc-list">
	        <ul id="list"></ul>
	    </div>
  	</aside>
  	<div class="content-container unit size3of4 lastUnit">
  		<div id="map"></div>
  	</div>
  </div>
</div>
