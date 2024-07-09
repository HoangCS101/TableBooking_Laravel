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
        <td>BookingID</td>
        <td>TableName</td>
        <td>Name</td>
        <td>PhoneNum</td>
        <td>Total</td>
        <td>State</td>
        <td>Date</td>
        <td>Timeslot</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->table_name }}</td>
            <td class="inner-table">{{ $t->guest_name }}</td>
            <td class="inner-table">{{ $t->pnum }}</td>
            <td class="inner-table">{{ $t->total }}</td>
            <td class="inner-table">
                <?php
                if ($t->state == 'not paid') echo '---';
                else echo 'Paid';
                ?>
            </td>
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
    // $(document).ready(function() {
    //     $('#myTable').DataTable();
    // });
    let table = new DataTable('#myTable');

    table.on('click', 'tbody tr', function() {
        let data = table.row(this).data();

        // alert('You clicked on ' + data[0] + "'s row");
        window.location.href = "{{ url('booking') }}/" + data[0];
    });
</script>
@endpush