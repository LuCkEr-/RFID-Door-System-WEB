<li>
	<a href="{{ url('/') }}"><i class="fa fa-dashboard fa-fw"></i> Koondpaneel</a>
</li>

<li>
	<a href="{{ url('/accounts') }}"><i class="fa fa-user fa-fw"></i> Kasutajad</span></a>
</li>

<li>
	<a href="{{ url('/cards') }}"><i class="fa fa-credit-card fa-fw"></i> Kaardid</a>
</li>

<li>
	<a href="{{ url('/groups') }}"><i class="fa fa-group fa-fw"></i> Grupid</a>
</li>

<li>
	<a href="{{ url('/logs') }}"><i class="fa fa-calendar fa-fw"></i> Pääsulogi</a>
</li>

@if( Auth::id() == 1 )
	<li>
		<a href="{{ url('/tokens') }}"><i class="fa fa-cogs fa-fw"></i> kontrolleri Tähised</a>
	</li>
@endif
