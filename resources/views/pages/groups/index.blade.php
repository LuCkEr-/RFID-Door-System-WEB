@extends('layouts.dashboard')

@section('contentTitle', 'Grupid')

@section('content')
	<div class="row">

		<div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
					Gruppide tabel

					<div class="pull-right">
						<div class="btn-toolbar" role="toolbar">

							<button type="button" class="btn btn-primary btn-default btn-xs" data-toggle="modal" data-target="#importModal">
	                            Lisa uus grupp
	                        </button>

						</div>
                    </div>

	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
					@include('partials.groupslist')
				</div>
	        </div>
	    </div>

		<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Lisa uus grupp</h4>
					</div>

					<form class="form" role="form" method="POST" action="{{ url('/groups/insert') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="modal-body">
							<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					            <input id="name" type="text" class="form-control" name="name" placeholder="Sisesta gruppi nimi" value="{{ old('name') }}" required autofocus>

					            @if ($errors->has('name'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('name') }}</strong>
					                </span>
					            @endif
					        </div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Lisa grupp</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Sulge</button>
						</div>

					</form>

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>

	</div>
@endsection
