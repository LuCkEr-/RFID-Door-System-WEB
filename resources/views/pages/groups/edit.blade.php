@extends('layouts.dashboard')

@section('contentTitle', 'Grupid')

@section('content')
	<div class="row">

		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Time table
				</div>
				<div class="panel-body">
					<label>Vali aeg ja kuupäev</label>
					<timeanddate
						:id={{ $editGroup -> groupID }}
						submiturl="/api/group/insert/time">
					</timeanddate>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Gruppile kuuluvad uksed
				</div>
				<div class="panel-body">
					<autocomplete
						:maxselected=10
						label=""
						placeholder="Ukse nimi"
						apisearch="/api/door/search?search="
						submiturl="/api/group/update/door"
						removeurl="/api/group/remove/door"
						:id={{ $editGroup -> groupID }}
						defualtvalue="/api/group/get/door"
					></autocomplete>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Muuda gruppi andmeid
				</div>
				<div class="panel-body">
					<simpleform
						label="Grupi nimi"
						placeholder=""
						submiturl="/api/group/update/name"
						:selectedid={{ $editGroup -> groupID }}
						selectedvalue="{{ $editGroup -> name }}"
					></simpleform>

					<form class="form" role="form" method="POST" action="{{ url('/groups/delete') }}">
				        {{ csrf_field() }}

						<input id="id" type="hidden" name="id" value="{{ $editGroup -> groupID }}" required>

			            <div class="form-group">
			                <button type="submit" class="btn btn-lg btn-danger btn-block">
			                    Kustuta grupp
			                </button>
			            </div>
				    </form>

				</div>
			</div>
		</div>

	</div>
	<div class="row">

		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Grupi Ajad
				</div>
				<div class="panel-body">
					@foreach($editGroup -> doors as $door)
						<autocomplete
	                        :maxselected=0
							label=""
							placeholder=""
							apisearch=""
							submiturl=""
							removeurl="/api/group/remove/time"
							:id={{ $door -> doorID }}
	                        defualtvalue="/api/group/get/time"
	                    ></autocomplete>
					@endforeach
				</div>
			</div>
		</div>

	</div>

@endsection
