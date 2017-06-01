@extends('layouts.dashboard')

@section('contentTitle', 'Pääsulogi')

@section('content')
	<div class="row">

		<div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
					Logid
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
					@include('partials.logslist')
				</div>
	        </div>
	    </div>

	</div>
@endsection
