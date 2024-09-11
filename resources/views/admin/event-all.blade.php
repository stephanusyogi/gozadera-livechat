@extends('layout.app')

@section('main')
<main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">All Event</h2>
                </div>
                <div class="right-part"></div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="eventTable" class="display text-center" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Live Chat</th>
                                <th>Event Name</th>
                                <th>Date & Time</th>
                                <th>Status<br>Started / Stopped</th>
                                <th>Renmark</th>
                                <th>Status<br>Active / Deleted</th>
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
<script type="text/javascript">
    function startLivechat(event, element) {
        event.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "Do you want to start the livechat?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = element.getAttribute('href');
            }
        });
    }

    function btnStopLivechat(event, element) {
        event.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "Do you want to stop the livechat?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = element.getAttribute('href');
            }
        });
    }

    function btnHistoryLivechat(event, element) {
        event.preventDefault();
        swal({
            title: 'Are you sure?',
            text: "Do you want to see the history?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.open(element.getAttribute('href'));
            }
        });
    }

    function deleteEvent(event, element) {
        event.preventDefault();
        const href = element.getAttribute('href');

        swal({
            title: 'Confirm Your Choice',
            text: "Are you sure about your choice?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Event',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = href;
            }
        });
    }

    function restoreEvent(event, element) {
        event.preventDefault();
        const href = element.getAttribute('href');

        swal({
            title: 'Confirm Your Choice',
            text: "Are you sure about your choice?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Restore Deleted Event',
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
        var table = $('#eventTable').DataTable({
            processing: true,
            columnDefs: [{
                className: "text-center",
                targets: "_all"
            }],
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
            columns: getColumns()
        });
        table.on('draw', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    });

    function getColumns() {
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
                data: 'livechat',
                name: 'livechat',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
            {
                data: 'name',
                name: 'name',
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return data.toUpperCase();
                }
            },
            {
                data: 'date_time',
                name: 'date_time',
                orderable: true,
                searchable: true,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
            {
                data: 'status_start_stop',
                name: 'status_start_stop',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
            {
                data: 'renmark',
                name: 'renmark',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
            {
                data: 'status_deleted',
                name: 'status_deleted',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
        ];
        return columns;
    }
</script>
@endpush
