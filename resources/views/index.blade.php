@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
<p>Welcome to this beautiful admin panel.</p>

<table id="myTable" class="display">
    <thead>
        <td>TableID</td>
        <td>Name</td>
        <td>PhoneNum</td>
        <td>Date</td>
        <td>Start</td>
        <td>End</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->table_id }}</td>
            <td class="inner-table">{{ $t->guest_name }}</td>
            <td class="inner-table">{{ $t->pnum }}</td>
            <td class="inner-table">{{ $t->date }}</td>
            <td class="inner-table">{{ $t->start_time }}</td>
            <td class="inner-table">{{ $t->end_time }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<a href="{{ route('booking.create') }}" class="btn btn-block bg-gradient-primary">New</a>
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