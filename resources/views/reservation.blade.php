@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservation')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Reservation')

{{-- Content body: main page content --}}

@section('content_body')
<p>Fill in the form to finish your table reservation.</p>
<div class="row">
    <div class="col-md-7">
        <div class="card card-primary" style="height: 100%">
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
                        <input type="date" class="form-control" id="date" style="width: 30%;" name='date' placeholder="Enter Date" onchange="showTable()">
                    </div>
                    <div class="form-group">
                        <label>Timeslot</label>
                        <select class="form-control select2 select2-hidden-accessible" style="width: 30%;" id="TS" name="time_slot" onchange="showTable()" tabindex="-1" aria-hidden="true">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Available Tables</label>
                        <select class="form-control select2 select2-hidden-accessible" style="width: 30%;" id="AT" name="AT" tabindex="-1" aria-hidden="true" onchange="preview()">
                            <option value="">Select Date and Time</option>
                        </select>
                    </div>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger" style="width: 95%;margin-left:2.5%">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-5">
        <!-- Empty form placeholder -->
        <div class="card card-primary" style="height: 100%">
            <div class="card-header">
                <h3 class="card-title">Table Preview</h3>
            </div>
            <form>
                <div class="card-body" id="preview">
                    <!-- Add any additional fields as needed -->
                    Nothing to see here (for now)<br>
                    Make changes on <strong>Available Tables</strong> to actually see me change.
                </div>
                <!-- <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div> -->
            </form>
        </div>
    </div>
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

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // console.log(this.responseText);
            document.getElementById("TS").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/timeslot/list", true);
    xhttp.send();
</script>
<script>
    function showTable() {
        var timeslot = document.getElementById("TS").value;
        var date = document.getElementById("date").value;
        console.log(timeslot + " " + date);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("AT").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/booking/filter" + "/" + encodeURIComponent(date) + "/" + timeslot, true);
        xhttp.send();
    }

    function preview() {
        var table_id = document.getElementById("AT").value;

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("preview").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/booking/preview/" + table_id, true);
        xhttp.send();
    }
</script>
@endpush