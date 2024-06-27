@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Table List')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Tables')

{{-- Content body: main page content --}}

@section('content_body')
<p>List of Tables.</p>

<table id="myTable" class="display">
    <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Created At</td>
        <td>Updated At</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->name }}</td>
            <td class="inner-table">{{ $t->created_at }}</td>
            <td class="inner-table">{{ $t->updated_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
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
        $('#myTable').DataTable();
    });
</script>
@endpush