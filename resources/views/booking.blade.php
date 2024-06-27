@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Bookings List')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Bookings')

{{-- Content body: main page content --}}

@section('content_body')
<p>View Booking List here!</p>

<table id="myTable" class="display">
    <thead>
        <td>TableID</td>
        <td>Name</td>
        <td>PhoneNum</td>
        <td>Date</td>
        <td>Timeslot</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->table_id }}</td>
            <td class="inner-table">{{ $t->guest_name }}</td>
            <td class="inner-table">{{ $t->pnum }}</td>
            <td class="inner-table">{{ $t->date }}</td>
            <td class="inner-table">{{ $t->time_slot }}</td>
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