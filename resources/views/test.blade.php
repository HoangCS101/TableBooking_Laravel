@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome')

{{-- Content body: main page content --}}

@section('content_body')
<p>Welcome to this beautiful admin panel.</p>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Quick Example</h3>
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
                <label for="table_id">Table Number</label>
                <input type="text" class="form-control" id="table_id" name='table_id' placeholder="Enter Table Number">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input id="date" class="form-control" type="date" />
            </div>
            <div class="form-group">
                <label for="start_time">Start</label>
                <input id="start_time" class="form-control" type="time" />
            </div>
            <div class="form-group">
                <label for="end_time">End</label>
                <input id="end_time" class="form-control" type="time" />
            </div>
            <!-- <div class="form-group">
                <label for="datePicker">Date + Arrival time</label>
                <div class='input-group date' id='datetimepicker'>
                    <input type='text' name='date' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="datetimepicker3">Stay time</label>
                <div class='input-group date' id='datetimepicker3'>
                    <input type='text' name='period' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
            </div> -->
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
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css"> -->
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> -->

<!-- <script type="text/javascript">
    $(function() {
        $('#datetimepicker').datetimepicker();
    });
</script> -->
<!-- <script type="text/javascript">
    $(function() {
        $('#datetimepicker').datetimepicker({
            icons: {
                time: 'glyphicon glyphicon-time',
                date: 'glyphicon glyphicon-calendar',
                up: 'glyphicon glyphicon-chevron-up',
                down: 'glyphicon glyphicon-chevron-down',
                previous: 'glyphicon glyphicon-chevron-left',
                next: 'glyphicon glyphicon-chevron-right',
                today: 'glyphicon glyphicon-screenshot',
                clear: 'glyphicon glyphicon-trash',
                close: 'glyphicon glyphicon-remove'
            },
            format: 'DD/MM/YYYY HH:mm',
            useCurrent: false,
            sideBySide: true,
            defaultDate: moment().add(1, 'day').startOf('hour'),
            minDate: moment().add(1, 'day').startOf('hour'),
            stepping: 15
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker3').datetimepicker({
            format: 'HH:mm',
            stepping: 15,
            minDate: moment().startOf('day').add(1, 'hours'),
            defaultDate: moment().startOf('day').add(1, 'hours'),
        });
    });
</script> -->
@endpush