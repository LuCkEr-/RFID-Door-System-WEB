<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
    <thead>
        <tr>
            <th class="never"></th>
            <th>Grupi nimi</th>
            <th>Liikmete arv</th>
        </tr>
    </thead>
</table>

@push('scripts')
	<!-- Tables -->
    <script>
		$(document).ready(function() {
			let table = $('#dataTables').DataTable({
				responsive: true,
				serverSide: true,
				processing: true,
				oLanguage: {sProcessing: '<i class="fa fa-cog fa-spin fa-3x fa-fw"></i>'},
                ajax: "/api/group",
                searchDelay: 500,
				columns: [
					{ data: 'groupID', name: 'groupID' },
					{ data: 'name', name: 'name' },
					{ data: 'users_count', name: 'users_count', searchable: false }
				]
			});

            // Make the row clickable
            $('.dataTable').on('click', 'tbody td', function() {
                var groupID = table.cell({ row: this.parentNode.rowIndex - 1, column : 0 }).data();
                document.location.href = '/groups/' + groupID
            });
		});
    </script>
@endpush
