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
					<button type="button" id="add-torrent-link" class="btn btn-default btn-lg"><i class="fa fa-plus-square-o"></i> Add Torrent</button>
				</div><!-- /#add-torrent-link -->

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg col-lg-2 col-md-2 col-sm-12 col-xs-12">Download</button>
				</div>
			</form>
			</div>
		</div><!-- /.panel -->

	</div><!-- /.col -->
</div><!-- /.row -->

<div class="row">

	<div class="col-lg-12 col-md-12">
	{{ $message }}
	</div>

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