@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Create order</div>

					<div class="panel-body">
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div><br />
						@endif
						@if (\Session::has('success'))
							<div class="alert alert-success">
								<p>{{ \Session::get('success') }}</p>
							</div><br />
						@endif

						<form method="POST" action="{{url('order')}}">
							{{csrf_field()}}
							<label for="product_id">Product</label>
							<select name="product_id" class="form-control">
								<option value=""></option>
								@foreach($products as $key => $item)
									<option value="{{$key}}">{{$item}}</option>
								@endforeach
							</select>

							<label for="quantity">Quantity</label>
							<input value="{{old('quantity')}}" name="quantity" type="text" class="form-control">

							<label for="color">Color</label>
							<input value="{{old('color')}}" name="color" type="text" class="form-control">
<hr>
							<input type="submit" class="btn btn-primary">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
