@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Roles')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Roles')

{{-- Content body: main page content --}}

@section('content_body')

<table id="myTable" class="display">
    <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Guard Name</td>
        <th>Actions</th>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->name }}</td>
            <td class="inner-table">{{ $t->guard_name }}</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-guard-name="{{ $t->guard_name }}">Edit</button>
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#P" data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-guard-name="{{ $t->guard_name }}">Permissions</button>
                <form action="{{ route('admin.roles.destroy', $t->id)}} " method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Create New Role Button -->
<button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#createTableModal">
    New Role
</button>
<!-- Modal for Creating a New Table -->
<div class="modal fade" id="createTableModal" tabindex="-1" role="dialog" aria-labelledby="createTableModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTableModalLabel">Create New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">New Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editRoleForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="editRoleName">Role Name</label>
                        <input type="text" class="form-control" id="editRoleName" name="name" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="editGuardName">Guard Name</label>
                        <input type="text" class="form-control" id="editGuardName" name="guard_name" required>
                    </div> -->
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Viewing Permissions -->
<div class="modal fade" id="P" tabindex="-1" role="dialog" aria-labelledby="PLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PLabel">Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="permissionsList">
                    
                </div>
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
        modal.find('.modal-body #editRoleName').val(button.data('name'));
        modal.find('.modal-body #editGuardName').val(button.data('guard-name'));

        // Adjust the form action URL if necessary
        modal.find('#editRoleForm').attr('action', '/admin/roles/' + id);
    });
</script>
<script>
    global = '';
    // Function to load permissions for a role
    function loadPermissions(roleId) {
        global = roleId;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("permissionsList").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/admin/roles/" + roleId + "/permissions", true);
        xhttp.send();
    }
    function togglePermission(perID)
    {
        var xhttp= new XMLHttpRequest();
        xhttp.open("GET", "/admin/roles/" + global + "/" + perID, true);
        xhttp.send();
    }
    // Event listener for the Permissions button click
    $('#P').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var roleId = button.data('id'); // Extract role ID from data-id attribute
        loadPermissions(roleId);
    });
</script>
@endpush