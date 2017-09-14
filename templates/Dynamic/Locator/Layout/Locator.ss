<div class="content-container unit size3of4 lastUnit">
	<h1>$Title</h1>
	<% if $Content %><div class="typography">$Content</div><% end_if %>

    <%-- This is where react hooks into the page --%>
    <div class="locator">
    </div>

</div>

<% require javascript('locator/client/dist/js/vendor.js') %>
<% require javascript('locator/client/dist/js/main.js') %>
<% require css('locator/client/dist/css/main.css') %>
