<markers>
	<% loop $Locations %><marker name="$Title.XML" lat="$Lat.XML" lng="$Lng.XML" category="$Category.Name.XML" address="$Address.XML" address2="" city="$City.XML" state="$State.XML" postal="$PostalCode.XML" country="$Country.XML" phone="$Phone.XML" web="$Website.XML" email="$Email.XML" featured="$Featured.NiceAsBoolean.XML" <% if $distance %>distance="$distance"<% end_if %>/>
	<% end_loop %>
</markers>