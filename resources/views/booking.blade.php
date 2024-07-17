@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Bookings List')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Bookings')

{{-- Content body: main page content --}}

@section('content_body')

<table id="myTable" class="display">
    <thead>
        @role('admin')
        <td>BookingID</td>
        <td>State</td>
        @endrole
        @role('user')
        <td>State</td>
        @endrole
        <td>Name</td>
        <td>PhoneNum</td>
        <td>Total</td>
        <td>TableName</td>
        <td>Date</td>
        <td>Timeslot</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr data-id="{{ $t->id }}">
            @role('admin')
            <td>{{ $t->id }}</td>
            <td class="inner-table">
                <?php
                if ($t->state == 'locked') echo 'Locked';
                elseif ($t->state == 'unlocked') echo 'Unlocked';
                else echo 'Paid';
                ?>
            </td>
            @endrole
            @role('user')
            <td class="inner-table">
                <?php
                if ($t->state == 'locked') echo 'Unpaid';
                elseif ($t->state == 'unlocked') echo 'Cancelled';
                else echo 'Paid';
                ?>
            </td>
            @endrole
            <td class="inner-table">{{ $t->guest_name }}</td>
            <td class="inner-table">{{ $t->pnum }}</td>
            <td class="inner-table">{{ $t->total }}</td>
            <td class="inner-table">{{ $t->table_name }}</td>
            <td class="inner-table">{{ $t->time_slot }}</td>
            <td class="inner-table">{{ $t->date }}</td>
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
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script>
    let table = new DataTable('#myTable');

    table.on('click', 'tbody tr', function() {
        let bookingId = $(this).data('id');

        window.location.href = "{{ url('booking') }}/" + bookingId;
    });
</script>
@endpush