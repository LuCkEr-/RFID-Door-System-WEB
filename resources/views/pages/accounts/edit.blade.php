@extends('layouts.dashboard')

@section('contentTitle', 'Kasutajad')

@section('content')
    <div class="row">

    	<div class="col-lg-6 col-md-6">

    		<div class="panel panel-default">
    			<div class="panel-heading">
    				Muuda kasutaja andmeid

                    <div class="pull-right">
						<div class="btn-toolbar" role="toolbar">

                            <form role="form" method="POST" action="{{ url('/accounts/delete') }}">
                                {{ csrf_field() }}

                                <input id="userID" type="hidden" name="userID" value="{{ $editAccount -> userID }}" required>

                                <button type="submit" class="btn btn-danger btn-default btn-xs">
                                    Kustuta kasutaja
                                </button>
                            </form>

                        </div>
		             </div>

    			</div>
    			<div class="panel-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <simpleform
        						label="Eesnimi"
        						placeholder=""
        						submiturl="/api/account/update/fname"
        						:selectedid={{ $editAccount -> userID }}
        						selectedvalue="{{ $editAccount -> firstName }}"
                            ></simpleform>

        					<simpleform
        						label="Perekonna nimi"
        						placeholder=""
        						submiturl="/api/account/update/lname"
                                :selectedid={{ $editAccount -> userID }}
                                selectedvalue="{{ $editAccount -> lastName }}"
                            ></simpleform>

                            <simpleform
        						label="E-Mail"
        						placeholder=""
        						submiturl="/api/account/update/email"
                                :selectedid={{ $editAccount -> userID }}
                                selectedvalue="{{ $editAccount -> email }}"
                            ></simpleform>

                            <simpleform
        						label="Telefoni number"
        						placeholder=""
        						submiturl="/api/account/update/mobile"
                                :selectedid={{ $editAccount -> userID }}
                                selectedvalue="{{ $editAccount -> mobilePhone }}"
                            ></simpleform>

                            <simpleform
        						label="Isikukood"
        						placeholder=""
        						submiturl="/api/account/update/pcode"
                                :selectedid={{ $editAccount -> userID }}
                                selectedvalue="{{ $editAccount -> personalCode }}"
                            ></simpleform>
    			         </div>

                        <div class="col-lg-6">
                            <autocomplete
                                :maxselected=10
        						label="Grupid"
        						placeholder="Grupi nimi"
        						apisearch="/api/group/search?search="
        						submiturl="/api/account/update/group"
                                removeurl="/api/account/remove/group"
        						:id={{ $editAccount -> userID }}
                                defualtvalue="/api/account/get/group"
                            ></autocomplete>

                            <autocomplete
                                :maxselected=10
        						label="Kaardid"
        						placeholder="Kaardi visuaalne ID"
        						apisearch="/api/card/search?search="
        						submiturl="/api/account/update/card"
        						removeurl="/api/account/remove/card"
        						:id={{ $editAccount -> userID }}
                                defualtvalue="/api/account/get/card"
                            ></autocomplete>
                        </div>

	                </div>
	            </div>
    		</div>

    	</div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
    				Kasutajad
                </div>
    			<!-- /.panel-heading -->
                <div class="panel-body" style="padding-bottom: 0px;">
                    @include('partials.accountslist')
                </div>
            </div>
        </div>

    </div>
@endsection
