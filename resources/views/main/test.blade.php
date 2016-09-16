@extends('layouts.master')

@section('content')

<div>
<button type="button" class="btn btn-primary" id="test-btn">Run</button>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

$('#test-btn').click(function() {

	$.ajax({
		url: 'http://yards01:8112/json',
		type: 'POST',
		headers: {'Accept': 'application/json', 'Content-Type': 'application/json'},
		data: {"id": 1, "method": "auth.login", "params": ['445N12th']}
	}).done(function(data) {
		console.log(data);
	});

});

</script>

@endsection