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
            <button type="button" class="btn btn-secondary border">Edit</button>
            <button type="button" class="btn btn-secondary border">Delete</button>
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
@endpush