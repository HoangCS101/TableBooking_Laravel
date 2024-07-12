@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Make Reservation')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Reservation')

{{-- Content body: main page content --}}

@section('content_body')
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
                        <select class="form-control select2 select2-hidden-accessible" style="width: 30%;" id="timeslot" name="timeslot" tabindex="-1" aria-hidden="true" onchange="preview()">
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
        <div class="card card-primary" style="height: 100%">
            <div class="card-header">
                <h3 class="card-title">Table Preview</h3>
            </div>
            <div class="card-body" id="preview">
                Nothing to see here (for now)<br>
                Make changes on <strong>Available Tables</strong> to actually see me change.
            </div>
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
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
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

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("timeslot").innerHTML = this.responseText;
                // timeslot is for Available Tables, basically you want to see if anyone has taken your desired table and what's left for ya.
            }
        };
        xhttp.open("GET", "/booking/filter" + "/" + encodeURIComponent(date) + "/" + timeslot, true);
        xhttp.send();
    }

    function preview() {
        var table_id = document.getElementById("timeslot").value;

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