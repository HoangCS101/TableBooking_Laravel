@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Add Table')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Add Table')

{{-- Content body: main page content --}}

@section('content_body')
<p>New Table Update.</p>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Table</h3>
    </div>
    <form method="POST" action="/table">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Table Name</label>
                <input type="text" class="form-control" id="name" name='name' placeholder="Enter Table Name">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" rows="3" id="description" name='description' placeholder="Add Description"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price (VND)</label>
                <input type="text" class="form-control" id="price" name='price' placeholder="Add Pricing">
            </div>
            <div class="form-group">
                <label for="picture_url">Picture URL</label>
                <input type="text" class="form-control" id="picture_url" name='picture_url' placeholder="Add Picture URL">
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
@endpush