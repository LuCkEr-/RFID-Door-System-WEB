@extends('layouts.dashboard')

@section('contentTitle', 'Koondpaneel')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-unlock fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $doorOpenCount }}</div>
                            <div>Ukse avamist täna</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/logs') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Vaata Pääsulogisid</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $userCount }}</div>
                            <div>Kasutajat on süsteemis</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/accounts') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Vaata Kasutajaid</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-credit-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $cardCount }}</div>
                            <div>Kaarti on süsteemis</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/cards') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Vaata Kaarte</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $groupsCount }}</div>
                            <div>Grupi on süsteemis</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/groups') }}">
                    <div class="panel-footer">
                        <span class="pull-left">Vaata Gruppe</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @if (count($doors))
        <div class="row">

        	<div class="col-lg-9">
        		<div class="panel panel-default">

        			<div class="panel-heading">
        				Uksed
        			</div>

        			<div class="panel-body">
                            @foreach ($doors as $door)
                                <div class="col-lg-3">
                                    <div class="list-group">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{ $door -> name }}</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($door -> logs as $log)
                                                        <tr>
                                                            @if ($log -> status == 200)
                                                                <td class="success">
                                                            @elseif ($log -> status == 404)
                                                                <td class="warning">
                                                            @elseif ($log -> status == 401)
                                                                <td class="danger">
                                                            @endif

                                                                @if (\App\Account::whereHas('cards', function($query) use ($log) {
                                                                    $query -> where('cardRFID', 'like', $log -> cardRFID);
                                                                }) -> first())
                                                                    {{ \App\Account::whereHas('cards', function($query) use ($log) {
                                                                        $query -> where('cardRFID', 'like', $log -> cardRFID);
                                                                    }) -> first() -> firstName . " " . \App\Account::whereHas('cards', function($query) use ($log) {
                                                                        $query -> where('cardRFID', 'like', $log -> cardRFID);
                                                                    }) -> first() -> lastName }}
                                                                @else
                                                                    Puudub Puudub
                                                                @endif
                                                                <span class="pull-right text-muted small"><em>{{ $log -> created_at -> diffForHumans() }}</em>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
        			</div>
        		</div>
        	</div>

        	<div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Viimased pääsulogid
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="list-group">
                                @foreach ($lastLogs as $log)

                                    @if ($log -> status == 200)
                                        <a href="#" class="list-group-item list-group-item-success">
                                    @elseif ($log -> status == 404)
                                        <a href="#" class="list-group-item list-group-item-warning">
                                    @elseif ($log -> status == 401)
                                        <a href="#" class="list-group-item list-group-item-danger">
                                    @endif

                                        @if (\App\Account::whereHas('cards', function($query) use ($log) {
                                            $query -> where('cardRFID', 'like', $log -> cardRFID);
                                        }) -> first())
                                            {{ \App\Account::whereHas('cards', function($query) use ($log) {
                                                $query -> where('cardRFID', 'like', $log -> cardRFID);
                                            }) -> first() -> firstName . " " . \App\Account::whereHas('cards', function($query) use ($log) {
                                                $query -> where('cardRFID', 'like', $log -> cardRFID);
                                            }) -> first() -> lastName }}
                                        @else
                                            Puudub Puudub
                                        @endif
                                        <span class="pull-right text-muted small"><em>{{ $log -> created_at -> diffForHumans() }}</em>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ url('/logs') }}" class="btn btn-default btn-block">Vaata veel pääsulogisid</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection
