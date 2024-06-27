@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservation')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'New Booking')

{{-- Content body: main page content --}}

@section('content_body')
<p>Fill in the form to finish your table reservation.</p>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Reservation Form</h3>
    </div>


    <form method="POST" action="/booking">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="phone_num">Phone Number</label>
                <input type="text" class="form-control" id="phone_num" name='phone_num' placeholder="Enter Phone Number">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" style="width: 20%;" name='date' placeholder="Enter Date" onchange="showTable()">
            </div>
            <div class="form-group">
                <label>Timeslot</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 20%;" id="TS" name="time_slot" onchange="showTable()" tabindex="-1" aria-hidden="true">
                    <option value="07:30 AM - 09:00 AM">07:30 AM - 09:00 AM</option>
                    <option value="09:00 AM - 10:30 AM">09:00 AM - 10:30 AM</option>
                    <option value="10:30 AM - 12:00 PM">10:30 AM - 12:00 PM</option>
                    <option value="12:00 PM - 01:30 PM">12:00 PM - 01:30 PM</option>
                    <option value="01:30 PM - 03:00 PM">01:30 PM - 03:00 PM</option>
                    <option value="03:00 PM - 04:30 PM">03:00 PM - 04:30 PM</option>
                    <option value="04:30 PM - 06:00 PM">04:30 PM - 06:00 PM</option>
                    <option value="06:00 PM - 07:30 PM">06:00 PM - 07:30 PM</option>
                    <option value="07:30 PM - 09:00 PM">07:30 PM - 09:00 PM</option>
                    <option value="09:00 PM - 10:30 PM">09:00 PM - 10:30 PM</option>
                </select>
            </div>
            <div class="form-group">
                <label>Available Tables</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 20%;" id="AT" name="AT" tabindex="-1" aria-hidden="true">
                    <option value="">Select Date and Time</option>
                </select>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
<script>
    function showTable(str) {
        var timeslot = document.getElementById("TS").value;
        var date = document.getElementById("date").value;

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("AT").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/filter" + "/" + encodeURIComponent(date) + "/" + encodeURIComponent(timeslot), true);
        xhttp.send();
    }
</script>
@endpush