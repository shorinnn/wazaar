<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<td>transaction id</td>
			<td>course name</td>
			<td>course owner</td>
			<td>course owner email</td>
			<td>original price</td>
			<td>discounted price</td>
			<td>wazaar cut</td>
			<td>instructor cut</td>
			<td>affiliate cut</td>
			<td>ltc cut</td>
			<td>2 tier affiliate cut</td>
			<td>2 tier publisher cut</td>
			<td>purchaser name</td>
			<td>purchaser email</td>
			<td>order date</td>
		</tr>
	</thead>
	<tbody>
		{{View::make('administration.orders.order_items', compact('orders'))}}
	</tbody>
</table>
<div class="container no-padding">
{{ $orders->appends(Input::only('start','limit'))->links() }}
</div>