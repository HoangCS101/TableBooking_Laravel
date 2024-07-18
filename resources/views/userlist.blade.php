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
        <td>Join Since</td>
        <th>Actions</th>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->name }}</td>
            <td class="inner-table">{{ $t->email }}</td>
            <td class="inner-table">{{ $t->created_at }}</td>
            <td>
                <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-guard-name="{{ $t->guard_name }}">Edit</button> -->
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#P" data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-guard-name="{{ $t->guard_name }}">Roles</button>
                <form action="/user/{{$t->id}}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal for Viewing Roles -->
<div class="modal fade" id="P" tabindex="-1" role="dialog" aria-labelledby="PLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PLabel">Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="rolesList">

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
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#myTable').DataTable();
    });
    global = '';
    // Function to load permissions for a role
    function loadRoles(userId) {
        global = userId;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("rolesList").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/user/" + userId + "/roles", true);
        xhttp.send();
    }

    function toggleRole(roleId) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/user/" + global + "/" + roleId, true);
        xhttp.send();
    }
    // Event listener for the Permissions button click

    $('#P').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var userId = button.data('id'); // Extract role ID from data-id attribute
        loadRoles(userId);
    });
</script>
@endpush