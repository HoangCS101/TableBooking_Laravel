@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Customer List')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Customers')

{{-- Content body: main page content --}}

@section('content_body')

<table id="myTable" class="display">
    <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Email</td>
        <td>Role</td>
        <td>Join Since</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->name }}</td>
            <td class="inner-table">{{ $t->email }}</td>
            <td class="inner-table">{{ $t->roles }}</td>
            <td class="inner-table">{{ $t->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    @csrf
                    @method("PUT")
                    <label for="name">Modify Roles</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input type="text" class="form-control" id="role" name='role'>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 50%;" id="act" name="act" tabindex="-1" aria-hidden="true">
                                    <option value="1">Give</option>
                                    <option value="0">Take</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary">Save Changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="clicked()">Delete User</button>
            </div>
        </div>
    </div>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
    let globalVar;

    function clicked() {
        // console.log('Clicked ID:', id);
        // AJAX request to delete resource
        if (confirm('Are you sure you want to delete this user?')) {
            fetch("{{ url('user') }}/" + globalVar, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token if using Laravel CSRF protection
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Handle successful deletion
                        console.log('Resource deleted successfully');
                        // Redirect to another page
                        window.location.href = "{{ url('user') }}";
                    } else {
                        // Handle error response
                        console.error('Error deleting resource');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
    $(document).ready(function() {
        let table = $('#myTable').DataTable();
        table.on('click', 'tbody tr', function() {
            let data = table.row(this).data();
            $('#exampleModalLabel').text(data[1]);
            globalVar = data[0];

            let $modalForm = $('#exampleModal').find('.modal-body form');
            $modalForm.attr('action', '/user/' + globalVar);

            let modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
        });
    });
</script>
@endpush