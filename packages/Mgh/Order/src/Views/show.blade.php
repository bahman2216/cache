@extends('layouts.app')

@section('content')
	<div class="container">
		<br/>
		@if (\Session::has('success'))
			<div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			</div><br/>
		@endif
		<table class="table table-striped">
			<thead>
			<tr>
				<th>Order ID</th>
				<th>Product</th>
				<th>Quantity</th>
				<th>Color</th>
				<th>Create date</th>
				<th colspan="2">Action</th>
			</tr>
			</thead>
			<tbody>
			@foreach($orders as $order)
				<tr>
					<td>{{$order['id']}}</td>
					<td>{{$order->product->name}}</td>
					<td>{{$order['quantity']}}</td>
					<td>{{$order['color']}}</td>
					<td>{{$order['created_at']}}</td>
					<td><a href="{{action('\Mgh\Order\Controllers\OrderController@edit', $order['id'])}}" class="btn btn-info">Edit</a>
					</td>
					<td>
						<form action="{{action('\Mgh\Order\Controllers\OrderController@destroy', $order['id'])}}" method="post">
							{{csrf_field()}}
							<input name="_method" type="hidden" value="DELETE">
							<button class="btn btn-danger" type="submit">Delete</button>
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{ $orders->links() }}
@endsection
