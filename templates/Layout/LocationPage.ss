<h2>$Title</h2>
<% if Content %><div class="typography">$Content</div><% end_if %>

<div id="store-locator-container">
  <div id="page-header">
    <h1>Using Chipotle as an Example</h1>
    <p>I used locations around Minneapolis and the southwest suburbs. So, for example, Edina, Plymouth, Eden Prarie, etc. would be good for testing the functionality. 
    You can use just the city as the address - ex: Edina, MN.</p>
  </div>
  
  <div id="form-container">
    <form id="user-location" method="post" action="#">
        <div id="form-input">
          <label for="address">Enter Address or Zip Code:</label>
          <input type="text" id="address" name="address" />
         </div>
        
        <div id="submit-btn"><input type="image" id="submit" name="submit" src="/locations/javascript/jQuery-Store-Locator-Plugin/images/submit.jpg" alt="Submit" /></div>
    </form>
  </div>

  <div id="map-container">
    <div id="loc-list">
        <ul id="list"></ul>
    </div>
    <div id="map"></div>
  </div>
</div>

  <script>
    $(function() {
      $('#map-container').storeLocator({
      	autoGeocode: true,
      	dataLocation: '/locations/xml',
      	//dataLocation: '/locations/javascript/jQuery-Store-Locator-Plugin/locations.xml',
      	listTemplatePath: '/locations/javascript/jQuery-Store-Locator-Plugin/templates/location-list-description.html',
      	infowindowTemplatePath: '/locations/javascript/jQuery-Store-Locator-Plugin/templates/infowindow-description.html'
      });
    });
  </script>