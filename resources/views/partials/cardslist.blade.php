<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
    <thead>
        <tr>
            <th class="never"></th>
            <th>Kaardi omanik</th>
            <th class="never">Perekonnanimi</th>
            <th>Visuaalne ID</th>
            <th>RFID</th>
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
                ajax: "/api/card",
                searchDelay: 500,
                columnDefs: [
                    {
                        render: function ( data, type, row ) {
                            return data +' '+ row.userLastName
                        },
                        targets: [ 1 ]
                    }
                ],
                columns: [
                    { data: 'cardID', name: 'cardID', searchable: false },
                    { data: 'userFirstName', name: 'user.firstName' },
                    { data: 'userLastName', name: 'user.lastName' },
                    { data: 'visualID', name: 'visualID' },
                    { data: 'cardRFID', name: 'cardRFID' }
                ]
            });

            // Make the row clickable
            $('.dataTable').on('click', 'tbody td', function() {
                var cardID = table.cell({ row: this.parentNode.rowIndex - 1, column : 0 }).data()
                document.location.href = '/cards/' + cardID
            });
        });
    </script>
@endpush
