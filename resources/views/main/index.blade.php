@extends('layouts.master')

@section('content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Torrent Download</h3>
			</div>
			<div class="panel-body">
			<form action="/add_torrent" method="post" id="add-file-form">
				{{ csrf_field() }}
				<div class="form-group">
					<label class="control-label" for="torrent_href">Paste Torrent Download URL</label>
					<input type="text" name="torrent_href" class="form-control input-lg" placeholder="Torrent Download Link">
				</div>

				<!-- This feature might be removed permanently -->
				{{--
				<div class="form-group">
					<button type="button" id="add-link-btn" class="btn btn-success pull-right"><i class="fa fa-plus"></i></button>
				</div>
				--}}

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-lg">Download</button>
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