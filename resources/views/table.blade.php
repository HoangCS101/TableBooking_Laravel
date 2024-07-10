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
            <img src="{{ $t->picture_url }}" alt="Photo 2" class="img-fluid">
            <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-secondary text-lg">
                    {{ $t->time_slot }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="callout" style="margin-bottom: 0; border-left-color: #6c757d;">
            <?php
            if ($t->state != 'paid') echo '<h5 style="margin-bottom: 10px;" id="demo"></h5>';
            ?>
            <script>
                var time = '{{ $t->created_at }}';
            </script>
            <h5 style="margin-bottom: 10px;"><small>Guest Name:</small> {{ $t->guest_name }}</h5>
            <p style="margin-bottom: 5px;">
                <small>Phone Number:</small> {{ $t->pnum }}<br>
                <small>Reservation Date:</small> {{ $t->date }}<br>
                <small>Table:</small> {{ $t->table_name }}<br>
                <small>Payment State:</small> {{ $t->total }} VND
                <?php
                if ($t->state == 'locked') echo '<span class="badge bg-danger">Not Paid</span>';
                elseif ($t->state == 'unlocked') echo '<span class="badge bg-secondary">Expired</span>';
                else echo '<span class="badge bg-success">Paid</span>';
                ?>
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
                                @method("PUT")
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

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Available Tables</label>
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 50%;" id="timeslot" name="timeslot" tabindex="-1" aria-hidden="true">
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
            <?php
            if ($t->state == 'locked') echo '<button type="button" class="btn btn-secondary border" data-toggle="modal" data-target="#paymentModal">Pay</button>';
            elseif ($t->state == 'unlocked') echo '<button type="button" class="btn btn-secondary border">Pay</button>';
            else echo '<button type="button" class="btn btn-success border">Paid</button>';
            ?>
            <!-- <button type="button" class="btn btn-secondary border" data-toggle="modal" data-target="#paymentModal">Pay</button> -->
            <!-- Modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('payment') }}/{{$t->id}}/{{$t->total}}" method="POST">
                                @csrf
                                <input type="hidden" name="" value="">
                                <button type="submit" class="btn custom-btn btn-lg" name="payUrl">
                                    <img src="{{ asset('momoicon.png') }}" alt="Momo Icon" class="btn-icon">
                                    <span class="btn-text">Pay with Momo</span>
                                    </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
        <div id="errorAlert" class="alert alert-danger" style="width: 100%;">
            Edit Failed!!!
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
@endforeach
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<style>
    .custom-btn {
        background-color: #c1177c;
        /* Pinkish red background */
        border-color: #c1177c;
        /* Matching border color */
        color: white;
        /* White text color */
        padding: 10px 20px;
        /* Adjust padding to create space for icon */
        position: relative;
        /* Position relative to allow absolute positioning */
        width: 100%;
    }

    .custom-btn:hover {
        background-color: #a00d5f;
        /* Darker pinkish red on hover */
        border-color: #a00d5f;
        /* Matching border color on hover */
    }

    .custom-btn .btn-icon {
        position: absolute;
        /* Position the icon absolutely */
        left: 2.5px;
        /* Fixed left position of the icon */
        top: 50%;
        /* Align icon vertically */
        transform: translateY(-50%);
        /* Center icon vertically */
        width: 45px;
        /* Fixed width of the icon */
        height: auto;
        /* Fixed height of the icon */
    }

    .custom-btn .btn-text {
        padding-left: 40px;
        /* Adjust padding to create space for the icon */
    }
</style>
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
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
                document.getElementById("timeslot").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/booking/filter" + "/" + encodeURIComponent(date) + "/" + encodeURIComponent(timeslot), true);
        xhttp.send();
    }
</script>
<script>
    // Function to fade out the alert
    function fadeOut(element) {
        var opacity = 1;
        var timer = setInterval(function() {
            if (opacity <= 0.01) {
                clearInterval(timer);
                element.style.display = 'none';
            }
            element.style.opacity = opacity;
            opacity -= 0.01;
        }, 50); // Adjust fade out speed (lower value means faster fade out)
    }

    // Fade out the alert after a delay
    window.onload = function() {
        var errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(function() {
                fadeOut(errorAlert);
            }, 500);
        } // Display duration before fade out (in milliseconds)
    };
</script>
<script>
    // Parse the date-time string into a Date object
    var dateTime = new Date(time);

    // Add 3 minutes to the Date object
    dateTime.setMinutes(dateTime.getMinutes() + 3);
    // Set the date we're counting down to
    var countDownDate = new Date(dateTime).getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // // Time calculations for days, hours, minutes and seconds
        // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = '<small>Time Remaining: </small>' + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
@endpush