
	document.getElementById('sidebar').style.display = 'none';
	
	// show large map of all locations on load
	showAllLocations();

	
	

//navigator.geolocation.getCurrentPosition(GetLocation);

function GetLocation(location) {
    alert(location.coords.latitude);
    alert(location.coords.longitude);
    alert(location.coords.accuracy);
 }