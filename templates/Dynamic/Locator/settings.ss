{
  "radii": [<% loop $Radii %>$Radius<% if not $Last %>,<% end_if %><% end_loop %>],
  <% if $Categories %>"categories": [<% loop $Categories %>
    {
      "ID": $ID,
      "Name": "$Name"
    }<% if not $Last %>,<% end_if %><% end_loop %>
  ],<% end_if %>
  "unit": "$Unit",
  "limit": $Limit,
  "clusters": $Clusters,
  "infoWindowTemplate": $InfoWindowTemplate.RAW,
  "listTemplate": $ListTemplate.RAW
}
