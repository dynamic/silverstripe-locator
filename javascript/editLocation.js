(function($) { 
    $(document).ready(function() { 
    	
    	
    	$("#CalcCoords").click(function() {
	  
		  	//alert('test');
			var address = document.getElementById('LocationDataObjectManager_Popup_DetailForm_Address').value;
			var city = document.getElementById('LocationDataObjectManager_Popup_DetailForm_City').value;
			var state = document.getElementById('LocationDataObjectManager_Popup_DetailForm_State').value;
			var zip = document.getElementById('LocationDataObjectManager_Popup_DetailForm_ZipCode').value;
			//var country = document.getElementById('Form_EditForm_Country').value;
			
			var longAddress;
			if (address) longAddress += address + ', ';
			if (city) longAddress += city + ' ';
			if (state) longAddress += state + ' ';
			if (zip) longAddress += zip;
			//if (country) longAddress += ' ' + country;
			
			if (!longAddress) {
				alert('Please enter an address');
				return false;
			}
			
			var geocoder = new GClientGeocoder();
			geocoder.getLatLng(longAddress, function(latlng) {
				if (!latlng) {
					alert(longAddress + ' not found');
				} else {
					// populate values of hidden lat and long fields
					//alert(latlng);
					
					var latlng = latlng.toString();
					latlng = latlng.replace('(', '');
					latlng = latlng.replace(')', '');
					coords = latlng.split(', ');
					//alert(coords[0]);
					
					
					document.getElementById('LocationDataObjectManager_Popup_DetailForm_Lat').value = coords[0];
					document.getElementById('LocationDataObjectManager_Popup_DetailForm_Long').value = coords[1];
				}
			});
		  
		});
		
	});
    	
    	
})(jQuery);