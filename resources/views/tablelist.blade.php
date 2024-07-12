@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Table List')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Tables')

{{-- Content body: main page content --}}

@section('content_body')

<table id="myTable" class="display">
    <thead>
        <td>ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Picture URL</td>
    </thead>

    <tbody>
        @foreach( $todo as $t )
        <tr>
            <td>{{ $t->id }}</td>
            <td class="inner-table">{{ $t->name }}</td>
            <td class="inner-table">{{ $t->description }}</td>
            <td class="inner-table">{{ $t->price }}</td>
            <td class="inner-table">{{ $t->picture_url }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="Photo 2" style="width: 100%;" class="img-fluid">
                <div class="mt-2">
                    <a href="#" id="pictureLink" target="_blank">View Full Image</a>
                </div>
            </div>
            <form id="form" method="POST" action="">
                @csrf
                @method('PUT')
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="clicked()">Delete Table</button>
            </div>
        </div>
    </div>
</div>
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
<style>
    .hover-window {
        position: absolute;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        padding: 10px;
        display: none;
        /* Hidden by default */
        z-index: 1000;
        /* Ensure it's above other content */
        pointer-events: none;
        /* Allow events to pass through to underlying elements */
    }
</style>
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<!-- <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script> -->
<script>
    let globalVar;

    function clicked() {
        // console.log('Clicked ID:', id);
        // AJAX request to delete resource
        if (confirm('Are you sure you want to delete this item?')) {
            fetch("{{ url('table') }}/" + globalVar, {
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
                        window.location.href = "{{ url('table') }}";
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
    $(document).ready(function() {
        let table = $('#myTable').DataTable({
            "columnDefs": [{
                "targets": 4, // Index of the "Picture URL" column
                "render": function(data, type, row, meta) {
                    if (data.length > 30) { // Adjust the threshold as needed
                        return data.substr(0, 30) + '...';
                    } else {
                        return data;
                    }
                }
            }]
        });

        $('#myTable tbody').on('mouseenter', 'tr', function(e) {
            let row = table.row(this).node();
            let data = table.row(this).data();

            // Create and position the hovering window
            let $hoverWindow = $('<div class="hover-window"><img src="' + data[4] + '" alt="Photo 2" class="img-fluid" style="width: 200px; height: auto;"></div>');
            $hoverWindow.appendTo('body'); // Append to body to make it floating

            // Position the hovering window relative to the mouse cursor
            $hoverWindow.css({
                top: e.clientY + 10, // Add offset to avoid overlapping with cursor
                left: e.clientX + 10, // Add offset to avoid overlapping with cursor
            }).fadeIn('fast'); // Fade in the hovering window
        }).on('mouseleave', 'tr', function() {
            // Remove the hovering window on mouse leave
            $('.hover-window').remove();
        }).on('mousemove', 'tr', function(e) {
            // Update hovering window position on mouse move
            $('.hover-window').css({
                top: e.clientY + 10,
                left: e.clientX + 10,
            });
        });

        table.on('click', 'tbody tr', function() {
            let data = table.row(this).data();
            $('#exampleModalLabel').text(data[1]);
            globalVar = data[0];

            let $modalImage = $('#exampleModal').find('.modal-body img');
            $modalImage.attr('src', data[4]);

            let $modalLink = $('#exampleModal').find('#pictureLink');
            $modalLink.attr('href', data[4]);
            
            $('#exampleModal').find('#name').attr('value', data[1]);
            $('#exampleModal').find('#description').val(data[2]);
            $('#exampleModal').find('#price').attr('value', data[3]);
            $('#exampleModal').find('#picture_url').attr('value', data[4]);
            $('#exampleModal').find('#form').attr('action', '/table/'+data[0]);

            let modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
        });
    });
</script>
@endpush