@extends('layout.app')

@section('main')
<main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">All Administrator</h2>
                </div>
                <div class="right-part"></div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="adminTable" class="display text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if ($admin->hasRole('Super Admin'))
                                    <th>Action</th>
                                @endif
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Type</th>
                                @if ($admin->hasRole('Super Admin'))
                                    <th>Actice / Deleted</th>
                                    <th>Created By</th>
                                @endif
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('custom_script')
<script>
    function deleteAdmin(event, element) {
        event.preventDefault();
        const href = element.getAttribute('href');

        swal({
            title: 'Confirm Your Choice',
            text: "Are you sure about your choice?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Admin',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = href;
            }
        });
    }

    function restoreAdmin(event, element) {
        event.preventDefault();
        const href = element.getAttribute('href');

        swal({
            title: 'Confirm Your Choice',
            text: "Are you sure about your choice?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Restore Inactive Admin',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = href;
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        var table = $('#adminTable').DataTable({
            paging: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            language: {
                search: '<i class="bi bi-search"></i>',
                searchPlaceholder: "Search here",
                paginate: {
                next: '<i class="bi bi-chevron-right"></i>',
                previous: '<i class="bi bi-chevron-left"></i>' 
                }
            },
            columnDefs: [{
                className: "text-center",
                targets: "_all"
            }],
            serverSide: true,
            columns: getColumns()
        });
        table.on('draw', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    });

    function getColumns() {
        @if ($admin->hasRole('Super Admin'))
            var columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'username',
                    name: 'username',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            const date = new Date(data);
                            return date.toLocaleString();
                        }
                        return data;
                    },
                    orderable: false,
                    searchable: false,
                },
            ];
        @else
            var columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'username',
                    name: 'username',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            const date = new Date(data);
                            return date.toLocaleString();
                        }
                        return data;
                    },
                    orderable: false,
                    searchable: false,
                },
            ];
        @endif
        return columns;
    }
</script>
@endpush