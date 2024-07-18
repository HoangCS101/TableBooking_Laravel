@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal Profile')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Profile')

{{-- Content body: main page content --}}

@section('content_body')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
    // $(document).ready(function() {
    //     $('#myTable').DataTable();
    // });
    let table = new DataTable('#myTable');

    table.on('click', 'tbody tr', function() {
        let data = table.row(this).data();

        // alert('You clicked on ' + data[0] + "'s row");
        window.location.href = "{{ url('booking') }}/" + data[0];
    });
</script>
@endpush