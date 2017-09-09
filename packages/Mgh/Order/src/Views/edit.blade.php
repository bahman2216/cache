@extends('layouts.app')

@section('content')
	<div class="container">
		<h2>Edit A Product</h2><br/>
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div><br/>
		@endif
		<form method="post" action="{{action('\Mgh\Order\Controllers\OrderController@update', $id)}}">
			{{csrf_field()}}
			<input name="_method" type="hidden" value="PATCH">

			<div class="row">
				<label for="product_id">Product</label>
				<select name="product_id" class="form-control">
					<option value=""></option>
					@foreach($products as $key => $item)
						@if($order->product_id == $key)
							<option selected value="{{$key}}">{{$item}}</option>
						@esle
							<option value="{{$key}}">{{$item}}</option>
						@endif
					@endforeach
				</select>

				<label for="quantity">Quantity</label>
				<input value="{{$order->quantity}}" name="quantity" type="text" class="form-control">

				<label for="color">Color</label>
				<input value="{{$order->color}}" name="color" type="text" class="form-control">
			</div>
<hr>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="form-group col-md-4">
					<button type="submit" class="btn btn-success" style="margin-left:38px">Update Order</button>
				</div>
			</div>
		</form>
	</div>
@endsection
