<markers>
	<% loop $Locations %><marker name="$Title.XML" lat="$Lat.XML" lng="$Lng.XML" category="$Category.Name.XML" address="$Address.XML" address2="$Address2.XML" city="$City.XML" state="$State.XML" postal="$PostalCode.XML" country="$Country.XML" phone="$Phone.XML" fax="$Fax.XML" web="$WebsiteURL.XML" email="$Email.XML" featured="$Featured.NiceAsBoolean.XML" <% if $distance %>distance="$Distance"<% end_if %>/>
	<% end_loop %>
</markers>
