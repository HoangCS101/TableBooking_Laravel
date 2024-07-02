@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Reservation Detail')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Reservation Detail')

{{-- Content body: main page content --}}

@section('content_body')
<p>Reservation Detail</p>
<br>
@foreach( $todo as $t )
<div class="container">
    <div class="col-sm-4">
        <div class="position-relative">
            <img src="https://static.rigg.uk/Files/casestudies/bistrotpierretables/sz/w960/bistrolargeroundrestauranttablewoodtopmetalbase.jpg" alt="Photo 2" class="img-fluid">
            <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-secondary text-lg">
                    {{ $t->time_slot }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="callout" style="margin-bottom: 0; border-left-color: #6c757d;">
            <h5 style="margin-bottom: 10px;"><small>Guest Name:</small> {{ $t->guest_name }}</h5>
            <p style="margin-bottom: 5px;">
                <small>Phone Number:</small> {{ $t->pnum }}<br>
                <small>Reservation Date:</small> {{ $t->date }}<br>
                <small>Table:</small> {{ $t->table_name }}<br>
                <small>Payment State:</small> <span class="badge bg-danger">Not Paid</span>
            </p>
        </div>
        <div class="btn-group d-flex justify-content-between" role="group" aria-label="Basic mixed styles example">
            <button type="button" class="btn btn-secondary border" data-toggle="modal" data-target="#exampleModal">Edit</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Change anything?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url('booking') }}/{{$t->id}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name='name' value="{{ $t->guest_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_num">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_num" name='phone_num' value="{{ $t->pnum }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" style="width: 50%;" name='date' value="{{ $t->date }}" onchange="showTable()">
                                    </div>
                                    <div class="form-group">
                                        <label>Timeslot</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 50%;" id="TS" name="time_slot" value="{{ $t->time_slot }}" onchange="showTable()" tabindex="-1" aria-hidden="true">
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
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 50%;" id="AT" name="AT" tabindex="-1" aria-hidden="true">
                                            <option value="{{ $t->table_id }}">{{ $t->table_name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-secondary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger border" onclick="clicked('{{ $t->id }}')">Delete</button>
            <button type="button" class="btn btn-secondary border">Pay</button>
        </div>
    </div>
</div>
@endforeach
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
    function clicked(id) {
        // console.log('Clicked ID:', id);
        // AJAX request to delete resource
        if (confirm('Are you sure you want to delete this item?')) {
            fetch("{{ url('booking') }}/" + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token if using Laravel CSRF protection
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Handle successful deletion
                        console.log('Resource deleted successfully');
                        // Redirect to another page
                        window.location.href = "{{ url('booking') }}";
                    } else {
                        // Handle error response
                        console.error('Error deleting resource');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }
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