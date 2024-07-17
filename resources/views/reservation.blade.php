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
                        <select class="form-control select2 select2-hidden-accessible" style="width: 30%;" id="time_slot" name="time_slot" onchange="showTable()" tabindex="-1" aria-hidden="true">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Available Tables</label>
                        <select class="form-control select2 select2-hidden-accessible" style="width: 30%;" id="table" name="table" tabindex="-1" aria-hidden="true" onchange="preview()">
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
            document.getElementById("time_slot").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/timeslot/list", true);
    xhttp.send();
</script>
<script>
    function showTable(str) {
        var timeslot = document.getElementById("time_slot").value;
        var date = document.getElementById("date").value;

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var responseData = JSON.parse(this.responseText); // Parse JSON response

                // Clear existing table content
                var tableElement = document.getElementById("table");
                tableElement.innerHTML = '';

                // Build HTML based on JSON data
                responseData.forEach(function(option) {
                    var optionHTML = '<option value="' + option.value + '">' + option.name + '</option>';
                    tableElement.innerHTML += optionHTML;
                });
            }
        };
        xhttp.open("GET", "/booking/filter" + "/" + encodeURIComponent(date) + "/" + encodeURIComponent(timeslot), true);
        xhttp.send();
    }

    function preview() {
        var table_id = document.getElementById("table").value;

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var responseData = JSON.parse(this.responseText); // Parse JSON response
                
                // Clear existing table content
                var tableElement = document.getElementById("preview");
                tableElement.innerHTML = '';

                var previewHTML = '<img src="' + responseData.picture_url + '" alt="Photo 2" class="img-fluid" style="width: 100%; height: auto;">' +
                    '<p style="margin-top: 20px"><strong>Description: </strong>' + responseData.description + '</p>';
                tableElement.innerHTML += previewHTML;
            }
        };
        xhttp.open("GET", "/booking/preview/" + table_id, true);
        xhttp.send();
    }
</script>
@endpush