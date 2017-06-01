@extends('layouts.dashboard')

@section('contentTitle', 'Kaardid')

@section('content')
	<div class="row">

		<div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	            	Kaartide tabel
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body" style="padding-bottom: 0px;">
					@include('partials.cardslist')
	            </div>
	        </div>
	    </div>

	</div>
@endsection
