<% if $Locations %>
<markers>
	<% loop $Locations %><marker name="$Title.XML" lat="$Lat.XML" lng="$Lng.XML" category="$Category.Name.XML" address="$Address.XML" address2="" city="$Suburb.XML" state="$State.XML" postal="$Postcode.XML" phone="$Phone.XML" web="$Website.XML" email="$Email.XML" featured="$Featured.NiceAsBoolean.XML" <% if $distance %>distance="$distance"<% end_if %> /><% end_loop %>
</markers>
<% end_if %>