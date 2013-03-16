<h2>$Title</h2>
<% if Content %><div class="typography">$Content</div><% end_if %>

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
