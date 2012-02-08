
	<h2>$Title</h2>
	<h3>$CurrentDateRange</h3>

	<form>
		<select name="URL" onchange="window.location.href= this.form.URL.options[this.form.URL.selectedIndex].value">
			<option value="">--- Change Month ---</option>
			<% control DateFilter %>
			<option value="{$Top.AbsoluteLink}report/{$Year}-{$Month}">{$Month}/{$Year}</option>
			<% end_control %>
		</select>
	</form>
	<p>&nbsp;</p>
	
	<div class="reportLeft">
		<h3>$Queries.TotalItems Queries</h3>
		<table cellpadding="4">
			<tr>
				<th>Query</th>
				<th>Number</th>
			</tr>
		<% control Queries.GroupedBy(Name) %>
			<tr>
				<td>$Name</td>
				<td>$Children.TotalItems</td>
			</tr>
		<% end_control %>
		</table>
	</div>

	<div class="reportRight">
		<h3>$Dealers.TotalItems Results</h3>
		<table cellpadding="4">
			<tr>
				<th>Company</th>
				<th>Results</th>
			</tr>
		<% control Dealers.GroupedBy(CompanyID) %>
			<tr>
				<td>$Company.Title</td>
				<td>$Children.TotalItems</td>
			</tr>
		<% end_control %>
		</table>
	</div>
	
	
<div class="clear"></div>

