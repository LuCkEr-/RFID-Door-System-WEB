@extends('layouts.dashboard')

@section('contentTitle', 'Tokens for controllers')

@section('content')
        <div class="row">

            <passport-clients></passport-clients>

            <passport-authorized-clients></passport-authorized-clients>

            <passport-personal-access-tokens></passport-personal-access-tokens>

        </div>
@endsection
