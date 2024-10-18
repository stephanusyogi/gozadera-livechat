@extends('layout.app')

@section('main')
    <main class="main-wrapper">
    <div class="container-fluid">
        <div class="inner-contents">
            <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                <div class="left-part">
                    <h2 class="text-dark">All Chats of {{ $event->name }}</h2>
                </div>
                <div class="right-part">
                    <select id="statusFilter" class="form-control">
                        <option value="PENDING">Pending Chats</option>
                        <option value="APPROVED">Approved Chats</option>
                        <option value="DISAPPROVED">Rejected Chats</option>
                        <option value="">All Chats</option>
                    </select>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="messageTable" class="display text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>Alias</th>
                                <th>Message</th>
                                <th>Table</th>
                                <th>IP Address</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>
<script>
    var table;
    $(document).ready(function() {
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });

        var channel = pusher.subscribe('chat-' + '{{ $event->id }}');

        channel.bind('message.sent', function(data) {
            // Reload the DataTable when a new message is sent
            table.ajax.reload(null, false);  // false -> don't reset the pagination
        });

        
        var channelUpdate = pusher.subscribe('chatUpdate-' + '{{ $event->id }}');

        // Optionally, you can bind other events like 'message.updateAdmin'
        channelUpdate.bind('message.updateAdmin', function(data) {
            // Reload the DataTable when a message is updated
            table.ajax.reload(null, false);  // false -> don't reset the pagination
        });

        var table = $('#messageTable').DataTable({
            paging: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url()->current() }}',
                data: function(d) {
                    d.status = $('#statusFilter').val();
                }
            },
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
            columns: getColumns(),
            initComplete: function() {
                $('#statusFilter').val('PENDING').trigger('change');
            }
        });

        // Event listener for status filter change
        $('#statusFilter').on('change', function() {
            table.ajax.reload();
        });

        // Re-initialize tooltips on table draw
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
                data: 'status',  // Add the status column here
                name: 'status',
                orderable: true,
                searchable: true,  // Allows searching by status
            },
            {
                data: 'sender_email',
                name: 'sender_email',
                orderable: true,
                searchable: true,
            },
            {
                data: 'sender_name',
                name: 'sender_name',
                orderable: true,
                searchable: true,
            },
            {
                data: 'content',
                name: 'content',
                orderable: true,
                searchable: true,
            },
            {
                data: 'table_name',
                name: 'table_name',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    return type === 'display' ? $('<div/>').html(data).text() : data;
                }
            },
            {
                data: 'ip_address',
                name: 'ip_address',
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
        return columns;
    }
</script>


<script>
    function deleteMessage(event, element) {
        event.preventDefault();
        const href = element.getAttribute('href');

        swal({
            title: 'Confirm Your Choice',
            text: "Are you sure about your choice?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Item',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                window.location.href = href;
            }
        });
    }

    function changeStatusMessage(event, element){
        const url = element.getAttribute('href');
        swal({
            title: 'Change Message Status',
            text: "Please choose the new status for this message:",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Approve',
            cancelButtonText: 'Disapprove',
        }).then((result) => {
            // Check what the user clicked (approve, disapprove, or cancel)
            let status = '';
            
            if (result.value) {
                // User clicked "Approve"
                status = 'APPROVED';
            } else if (result.dismiss === 'cancel') {
                // User clicked "Disapprove"
                status = 'DISAPPROVED';
            }

            // Send the status update via AJAX
            if (status) {
                sendStatusUpdate(url, status);
            }
        });
    }

    function sendStatusUpdate(url, status) {
        $.ajax({
            url: url,  // The URL to send the status change request
            method: 'POST',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'  // Include CSRF token for Laravel
            },
            success: function(response) {
                swal({
                    title: 'Status Updated',
                    text: `The message status has been changed to ${status}.`,
                    type: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (status === 'DISAPPROVED') {
                        $('#messageTable').DataTable().ajax.reload(null, false);
                    }
                });
            },
            error: function(error) {
                swal({
                    title: 'Error',
                    text: 'There was an error updating the message status.',
                    type: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

</script>
@endpush
