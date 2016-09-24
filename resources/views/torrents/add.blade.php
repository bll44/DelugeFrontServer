@extends('layouts.master')

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Torrent Download</h3>
			</div>
			<div class="panel-body">
			<form action="/add_torrent" method="post" id="add-file-form">
				{{ csrf_field() }}
				<p>Paste Torrent Download URLs</p>
				<div id="torrent-links">
					<div class="form-group" class="torrent-link-input-container">
						<input type="text" name="torrent_href[]" class="form-control input-lg torrent-link-input" placeholder="Torrent Download Link" autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<button type="button" id="add-torrent-link" class="btn btn-default"><i class="fa fa-plus-square-o"></i> Add Torrent</button>
				</div><!-- /#add-torrent-link -->

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-12 col-xs-12" id="download-btn">Download</button>
				</div>
			</form>
			</div>
		</div><!-- /.panel -->

	</div><!-- /.column -->
</div><!-- /.row -->

@if(isset($message))
<div class="row">
	<div class="col-lg-12 col-md-12">
		<h2 class="text-success" id="status-message">{{ $message }}</h2>
	</div>
</div><!-- /.row -->
@endif

<div class="row hidden">
	<div id="submit-error" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h2></h2>
	</div>
</div>

<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<table class="table">
			<thead>
				<th>Tracker Domain</th>
				<th>.torrent File Location</th>
				<th>Link</th>
				<th>Downloaded at</th>
			</thead>
			<tbody>
				@foreach($torrents as $row)
				<tr>
					<td>{{ $row->domain }}</td>
					<td>{{ substr($row->fs_archive_location, 0, 55) . '....torrent' }}</td>
					<td>{{ substr($row->link, 0, 34) . '...' }}</td>
					<td>{{ $row->created_at }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<button type="button" class="btn btn-warning btn-sm">View All Torrent Download History</button>

	</div><!-- /.column -->

</div><!-- /.row -->

@endsection

@section('scripts')

<script type="text/javascript">

// Fade out status message after 5 seconds
$(document).ready(function() {
	if($('#status-message').length) {
		setTimeout(function() {
			$('#status-message').fadeOut();
		}, 5000);
	}
});

$('#add-torrent-link').click(function() {
	$('.torrent-link-input').last().parent().clone().appendTo('#torrent-links');
	$('.torrent-link-input').last().val('');
});

$('#add-file-form').submit(function() {
	var linkInputs = $('.torrent-link-input');
	linkInputs.each(function() {
		if($(this).val().trim().length < 1) {
			$(this).parent().addClass('has-error');
			$('#submit-error').parent().removeClass('hidden');
			$('#submit-error h2').text('Invalid/Empty inputs, please correct these and retry.');
			$('#submit-error h2').addClass('text-danger');
			event.preventDefault();
		}
	});
});

</script>

@endsection