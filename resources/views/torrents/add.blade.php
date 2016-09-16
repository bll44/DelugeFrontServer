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
				<div class="form-group" id="torrent-links">
					<label class="control-label" for="torrent_href">Paste Torrent Download URLs</label>
					<input type="text" name="torrent_href[]" class="form-control input-lg torrent-link-input" placeholder="Torrent Download Link" autocomplete="off">
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

<div class="row">

	<div class="col-lg-12 col-md-12">
	<p class="text-success">{{ $message }}</p>
	</div>

</div><!-- /.row -->

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

	</div><!-- /.column -->

</div><!-- /.row -->

@endsection

@section('scripts')

<script type="text/javascript">

$('#add-torrent-link').click(function() {
	$('.torrent-link-input').last().clone().appendTo('#torrent-links');
	$('.torrent-link-input').last().val('');
});

</script>

@endsection