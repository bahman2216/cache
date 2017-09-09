@extends('layouts.app')

@section('extra_before_css')

	<link rel="stylesheet" href="{{ URL::asset('/') }}vendor/easy-autocomplete/easy-autocomplete.min.css" />
	<link rel="stylesheet" href="{{ URL::asset('/') }}vendor/easy-autocomplete/easy-autocomplete.themes.min.css" />

@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Search in orders by product</div>

					<div class="panel-body">
{{--						{!! Form::open(['url' => '/book', 'class' => '']) !!}--}}
							{!! Form::hidden('product_id', null, array_merge(['id'=> 'product_id'])) !!}
							{!! Form::text('service', null, array_merge(['autocomplete'=> 'off', 'id'=> 'search-box', 'class' => 'form-control', 'placeholder' => 'Type product name here...'])) !!}
{{--						{!! Form::close() !!}--}}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('extra_script')
	{{--<script language="JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>--}}
	<script language="JavaScript" src="{{ URL::asset('/') }}vendor/easy-autocomplete/jquery.easy-autocomplete.min.js"></script>

	<script>
		var options = {
			url: function (phrase) {
				return "/searchItem";
			},

			list: {

				onSelectItemEvent: function() {
					var index = $("#search-box").getSelectedItemData().product_id;

					$("#product_id").val(index).trigger("change");
				}
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					dataType: "json"
				}
			},

			preparePostData: function (data) {
				data.phrase = $("#search-box").val();
				data._token = $("input[name=_token]").val();
				return data;
			},

			requestDelay: 400,

			getValue: "name",

			template: {
				type: "description",
				fields: {
					description: "category"
				}
			}
		};

		$("#search-box").easyAutocomplete(options);

	</script>
@stop