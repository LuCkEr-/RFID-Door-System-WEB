<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
    <thead>
        <tr>
            <th class="never"></th>
            <th>Eesnimi</th>
            <th>Perekonnanimi</th>
            <th>E-Mail</th>
            <th>Telefoni number</th>
            <th>Isikukood</th>
            <th>Grupid</th>
            <th>Kaardi visuaalne ID</th>
        </tr>
    </thead>
</table>


@push('scripts')
	<!-- Tables -->
    <script>
		$(document).ready(function() {
			var table = $('#dataTables').DataTable({
				responsive: true,
				serverSide: true,
				processing: true,
				oLanguage: {sProcessing: '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>'},
				ajax: "/api/account",
                searchDelay: 500,
				columns: [
					{ data: 'userID', name: 'userID', searchable: false },
					{ data: 'firstName', name: 'firstName' },
					{ data: 'lastName', name: 'lastName' },
					{ data: 'email', name: 'email' },
					{ data: 'mobilePhone', name: 'mobilePhone' },
					{ data: 'personalCode', name: 'personalCode' },
					{ data: 'groups', name: 'groups.name' },
					{ data: 'cards', name: 'cards.visualID' }
				]
			});

            // Make the row clickable
            $('.dataTable').on('click', 'tbody td', function() {
                var userID = table.cell({ row: this.parentNode.rowIndex - 1, column : 0 }).data()
                document.location.href = '/accounts/' + userID
            });
		});
    </script>
@endpush
