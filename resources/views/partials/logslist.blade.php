<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
    <thead>
        <tr>
            <th class="never"></th>
            <th>Kaardi omanik</th>
            <th class="never"></th>
            <th>Uks</th>
            <th>Kuupäev</th>
            <th class="never"></th>
            <th class="never"></th>
        </tr>
    </thead>
</table>

@push('scripts')
	<!-- Tables -->
    <script>
		$(document).ready(function() {
			$('#dataTables').DataTable({
				responsive: true,
				serverSide: true,
				processing: true,
				oLanguage: {sProcessing: '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>'},
                ajax: "/api/log",
                searchDelay: 500,
                order: [[ 4, 'desc' ]],
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ){
                    if( aData.status == 200 ){
                        $('td', nRow).addClass('success');
                    } else if ( aData.status == 401 ) {
                        $('td', nRow).addClass('danger');
                    } else if ( aData.status == 404 ) {
                        $('td', nRow).addClass('warning');
                    }

                },
                columnDefs: [
                    {
                        render: function ( data, type, row ) {
                            if (row.status == 200 || (data.length !== 0 || row.userLastName.length !== 0)) {
                                return data + ' ' + row.userLastName
                            } else {
                                return '<form class="form" role="form" method="POST" action="{{ url('/cards/insert') }}">{{ csrf_field() }}Tundmatu kaart <input id="cardRFID" type="hidden" name="cardRFID" value="' + row.cardRFID + '" required><button type="submit" class="btn btn-primary btn-default btn-xs">Lisa uue kaardina</button></form>'
                            }
                        },
                        targets: [ 1 ]
                    },
                    {
                        render: function ( data, type, row ) {
                            var date = row.created_at_date.split('-'); // [0] year [1] month [2] day
                            return data + " " + date[2] + '/' + date[1] + '/' + date[0];
                        },
                        targets: 4
                    }
                ],
				columns: [
                    { data: 'status', name: 'status', searchable: false },
					{ data: 'userFirstName', name: 'user.firstName' },
					{ data: 'userLastName', name: 'user.lastName' },
					{ data: 'doorName', name: 'door.name' },
					{ data: 'created_at_time', name: 'created_at' },
					{ data: 'created_at_date', name: 'created_at' },
                    { data: 'logID', name: 'logID', searchable: false },
				]
			});
		});

		jQuery(document).ready(function($) {
		    $(".clickable-row").click(function() {
		        window.location = $(this).data("href");
		    });
		});
    </script>
@endpush
