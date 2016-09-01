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
				<div class="form-group">
					<label class="control-label" for="torrent_href">Paste Torrent Download URLs</label>
					<input type="text" name="torrent_href[]" class="form-control input-lg" placeholder="Torrent Download Link">
				</div>

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