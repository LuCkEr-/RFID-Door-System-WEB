@extends('layouts.dashboard')

@section('contentTitle', 'Kasutajad')

@section('content')
	<div class="row">

		<div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                Kasutajate tabel
					<div class="pull-right">
						<div class="btn-toolbar" role="toolbar">

	                        <button type="button" class="btn btn-primary btn-default btn-xs" data-toggle="modal" data-target="#importModal">
	                            Importi kasutajad
	                        </button>

							<button type="button" class="btn btn-primary btn-default btn-xs" data-toggle="modal" data-target="#newUserModal">
								Lisa uus kasutaja
							</button>

						</div>
                    </div>
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body" style="padding-bottom: 0px;">
	                @include('partials.accountslist')
	            </div>
	        </div>
	    </div>

		<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Andmeimport</h4>
					</div>

					<form class="form" role="form" method="POST" action="{{ url('/accounts/import') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="modal-body">
							<div class="form-group{{ $errors->has('importFile') ? ' has-error' : '' }}">
								 <label for="importFile">Lisa .csv fail</label>
								<input id="importFile" type="file" name="importFile" required>

								@if ($errors->has('importFile'))
									<span class="help-block">
										<strong>{{ $errors->first('importFile') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Importi kasutajad</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>

					</form>

				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>



		<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="myModalLabel">Lisa uus kasutaja</h4>
					</div>

					<form class="form" role="form" method="POST" action="{{ url('/accounts/insert') }}" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="modal-body">

							<div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
					            <input id="firstName" type="text" class="form-control" name="firstName" placeholder="Sisesta uue kasutaja Eesnimi" value="{{ old('firstName') }}" required autofocus>

					            @if ($errors->has('firstName'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('firstName') }}</strong>
					                </span>
					            @endif
					        </div>

							<div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
					            <input id="lastName" type="text" class="form-control" name="lastName" placeholder="Sisesta uue kasutaja Perekonnanimi" value="{{ old('lastName') }}" required autofocus>

					            @if ($errors->has('lastName'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('lastName') }}</strong>
					                </span>
					            @endif
					        </div>

						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Lisa kasutaja</button>
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
