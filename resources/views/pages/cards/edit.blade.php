@extends('layouts.dashboard')

@section('contentTitle', 'Cards')

@section('content')
	<div class="row">

		<div class="col-lg-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Muuda kaardi andmeid

					<div class="pull-right">
						<div class="btn-toolbar" role="toolbar">

							<form role="form" method="POST" action="{{ url('/cards/delete') }}">
								{{ csrf_field() }}

								<input id="cardID" type="hidden" name="cardID" value="{{ $editcard -> cardID }}" required>

								<button type="submit" class="btn btn-danger btn-default btn-xs">
									Kustuta kaart
								</button>
							</form>

						</div>
                    </div>

				</div>
				<div class="panel-body">
					<simpleform
						label="Kaardi RFID"
						placeholder=""
						submiturl="/api/card/update/rfid"
						:selectedid={{ $editcard -> cardID }}
						selectedvalue="{{ $editcard -> cardRFID }}"
                    ></simpleform>

					<simpleform
						label="Kaardi Visuaalne ID"
						placeholder=""
						submiturl="/api/card/update/vid"
                        :selectedid={{ $editcard -> cardID }}
                        selectedvalue="{{ $editcard -> visualID }}"
                    ></simpleform>

                    <autocomplete
                        :maxselected=1
						label="Kaardi omanik"
						placeholder="Nimi"
						apisearch="/api/account/search?search="
						submiturl="/api/card/update/account"
						removeurl="/api/card/remove/account"
						:id={{ $editcard -> cardID }}
                        defualtvalue="/api/card/get/account"
                    ></autocomplete>

				</div>
			</div>
		</div>

		<div class="col-lg-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					Kaardid
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body" style="padding-bottom: 0px;">
                    @include('partials.cardslist')
				</div>
			</div>
		</div>

	</div>
@endsection
