{
  "locations": [
    <% loop $Locations %>{
      "ID": $ID,
      "Title": "$Title",
      "Featured": $Featured,
      "Website": "$Website",
      "Phone": "$Phone",
      "Fax": "$Fax",
      "Email": "$Email",
      "Address": "$Address",
      "Address2": "$Address2",
      "City": "$City",
      "State": "$State",
      "PostalCode": "$PostalCode",
      "Country": "$Country",
      "Distance": <% if $Distance %>$Distance<% else %>-1<% end_if %>,
      "Lat": $Lat,
      "Lng": $Lng
    }<% if not $Last %>,<%end_if%><% end_loop %>
  ]<% if $AddressCoords %>,
  "center": {
    "Lat": $AddressCoords.Lat,
    "Lng": $AddressCoords.Lng
  }<% end_if %>
}
