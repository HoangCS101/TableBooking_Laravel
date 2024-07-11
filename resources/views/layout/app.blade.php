@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
{{ config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')

<head>
    <!-- Other meta tags and stylesheets -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Other scripts -->
</head>
@hasSection('content_header_title')
<h1 class="text-muted">
    @yield('content_header_title')

    @hasSection('content_header_subtitle')
    <small class="text-dark">
        <i class="fas fa-xs fa-angle-right text-muted"></i>
        @yield('content_header_subtitle')
    </small>
    @endif
</h1>
@endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
<button class="btn btn-secondary" data-widget="control-sidebar" style="margin-bottom: 10px">
    <i class="fas fa-comment"></i>
</button>
<aside id="chatbox" class="control-sidebar control-sidebar-light" style="height: 100%; width: auto;height: auto">
    <div class="p-3" style="height: 100%; overflow: auto;">
        <div class="max-w-full max-h-full overflow-x-auto overflow-y-auto">
            <div id="container">
                <aside>
                    <header>
                        <input type="text" placeholder="search">
                    </header>
                    <ul>
                        <li>
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg" alt="">
                            <div>
                                <h2>Prénom Nom</h2>
                                <h3>
                                    <span class="status orange"></span>
                                    offline
                                </h3>
                            </div>
                        </li>
                        <li>
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_02.jpg" alt="">
                            <div>
                                <h2>Prénom Nom</h2>
                                <h3>
                                    <span class="status green"></span>
                                    online
                                </h3>
                            </div>
                        </li>
                        <li>
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_03.jpg" alt="">
                            <div>
                                <h2>Prénom Nom</h2>
                                <h3>
                                    <span class="status orange"></span>
                                    offline
                                </h3>
                            </div>
                        </li>

                    </ul>
                </aside>
                <main>
                    <header>
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg" alt="">
                        <div>
                            <h2>Chat with Vincent Porter</h2>
                            <h3>already 1902 messages</h3>
                        </div>
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png" alt="">
                    </header>
                    <ul id="chat">

                    </ul>
                    <footer>
                        <footer>
                            <textarea id="messageInput" placeholder="Type your message"></textarea>
                            <a href="#" id="sendMessage">Send</a>
                        </footer>
                    </footer>
                </main>
            </div>
        </div>
    </div>
</aside>
@yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
<div class="float-right">
    Version: {{ config('app.version', '1.0.0') }}
</div>

<strong>
    <a href="{{ config('app.company_url', '#') }}">
        {{ config('app.company_name', 'My company') }}
    </a>
</strong>
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>
    $(document).ready(function() {
        // Function to fetch messages from server
        function fetchMessages() {
            $.ajax({
                url: '/chirps', // Update with your Laravel route URL
                method: 'GET',
                success: function(response) {
                    // Clear existing messages
                    $('#chat').empty();
                    // console.log(response);
                    // Append fetched messages to chatbox
                    response.messages.forEach(function(message) {
                        // var messageTypeClass = (message.sender_id == 1) ? 'me' : 'you';
                        // var messageSenderName = (message.sender_id == 1) ? 'admin' : 'user';
                        // console.log(message.name);
                        var messageHTML = `
                            <li class="${message.type}">
                                <div class="entete">
                                    <h2>${message.name}</h2>
                                    <h3>${message.created_at}</h3>
                                </div>
                                <div class="triangle"></div>
                                <div class="message">
                                    ${message.message}
                                </div>
                            </li>
                        `;
                        $('#chat').append(messageHTML);
                    });
                    $('#chat').scrollTop($('#chat')[0].scrollHeight);
                },
                error: function(xhr, status, error) {
                    // console.log(response);
                    console.error('Error fetching messages:', error);
                }
            });
        }

        // Fetch messages initially on page load
        fetchMessages();

        // Set interval to fetch messages periodically (e.g., every 5 seconds)
        setInterval(fetchMessages, 500); // Adjust interval as needed
    });
</script>
<script>
    $(document).ready(function() {
        function sendMessage() {
            // event.preventDefault();
            console.log('clicked');
            var message = $('#messageInput').val();
            console.log(message);
            if (message === '') {
                return; // Exit if the message is empty
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // AJAX request to send the message
            $.ajax({
                url: '/chirps', // Update with your Laravel route URL
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the headers
                },
                data: {
                    message: message
                },
                success: function(response) {
                    console.log('Message sent successfully:', response);
                    $('#messageInput').val(''); // Clear the message input field
                    // Optionally, update the chatbox with the sent message (not implemented here)
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message:', error);
                }
            });
        }
        // Handle click event on the "Send" link
        $('#sendMessage').click(function(event) {
            event.preventDefault();
            sendMessage(); // Call the sendMessage function
        });

        // Handle key press event in the textarea (Enter key)
        $('#messageInput').keypress(function(event) {
            if (event.which === 13) { // Check if Enter key is pressed (key code 13)
                event.preventDefault(); // Prevent default Enter behavior (new line)
                sendMessage(); // Call the sendMessage function
            }
        });
    });
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<link rel="stylesheet" href="{{ asset('chatbox.css') }}">
<style type="text/css">
    /* {{-- You can add AdminLTE customizations here --}} */
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
    */
</style>
@endpush
