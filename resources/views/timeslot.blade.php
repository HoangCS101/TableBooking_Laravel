@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Timeslot')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Timeslot')

{{-- Content body: main page content --}}

@section('content_body')
<p>List of Permissions.</p>

<table id="myTable" class="display">
    <thead>
        <td>ID</td>
        <td>Slot</td>
        <td>Price</td>
        <th>Actions</th>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->slot_name }}</td>
            <td class="inner-table">{{ $t->price }}</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="{{ $t->id }}" data-name="{{ $t->slot_name }}" data-price="{{ $t->price }}">Edit</button>
                <form action="/timeslot/{{$t->id}}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Create New Permission Button -->
<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#createTableModal">
    New Timeslot
</button>
<!-- Modal for Creating a New Table -->
<div class="modal fade" id="createTableModal" tabindex="-1" role="dialog" aria-labelledby="createTableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTableModalLabel">Create New Timeslot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/timeslot">
                    @csrf
                    <div class="form-group">
                        <label for="name">New Timeslot (for now is a string)</label>
                        <input type="text" class="form-control" id="slot_name" name="slot_name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Viewing Table Details -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Timeslot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPermissionForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="editPermissionName">Timeslot</label>
                        <input type="string" class="form-control" id="editPermissionName" name="slot_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editGuardName">Price</label>
                        <input type="text" class="form-control" id="editGuardName" name="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    $(document).ready(function() {
        let table = $('#myTable').DataTable();
    });
    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes

        // Example of populating form fields
        var modal = $(this);
        // console.log(button.data('price'));
        modal.find('.modal-body #editPermissionName').val(button.data('name'));
        modal.find('.modal-body #editGuardName').val(button.data('price'));

        // Adjust the form action URL if necessary
        modal.find('#editPermissionForm').attr('action', '/timeslot/' + id);
    });
</script>
@endpush