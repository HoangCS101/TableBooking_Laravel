@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
{{ config('adminlte.title') }}
@hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<button class="btn btn-secondary" data-widget="control-sidebar" style="margin-bottom: 20px">
    <i class="fas fa-comment"> ChatBox</i>
</button>
<aside id="chatbox" class="control-sidebar control-sidebar-light" style="height: 100%; width: auto;height: auto">
    <div class="p-3" style="height: 100%; overflow: auto;">
        <div class="max-w-full max-h-full overflow-x-auto overflow-y-auto">
            <div id="container">
                <aside>
                    <header>
                        <input type="text" placeholder="search">
                    </header>
                    <ul id="users">

                    </ul>
                </aside>
                <main>
                    <header id="header">
                        
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
    <button class="btn btn-sm" onclick="genToken()">
        <i class="fas fa-key"> Generate One-time Token</i>
    </button>
</div>

<strong>
    <a href="{{ config('app.company_url', '#') }}">
        {{ config('app.company_name', 'RestaurantName') }}
    </a>
</strong>
Table-Booking App Version: {{ config('app.version', '1.0.0') }}
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    function genToken() {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                var token = response.token;

                // Extract and trim the token value
                var trimmedToken = token.split('|')[1]; // Split by '|' and get the second part
                trimmedToken = trimmedToken.trim(); // Trim any leading or trailing whitespace

                // Display confirmation or use the trimmed token as needed
                alert('Token generated successfully, SAVE BEFORE CANCEL : ' + trimmedToken);
            } else if (this.readyState == 4) {
                // Handle errors or other statuses if needed
                // alert('Error generating token. Status: ' + this.status);
                alert('User has no permission to generate one-time token.');
            }
        };
        xhttp.open("GET", "/token/create/", true);
        xhttp.send();
    }
</script>
<script>
    let globalVar = null;

    // Pusher.logToConsole = true;
    var pusher = new Pusher('fbd1b1e67dcce929509f', {
        cluster: 'ap1'
    });
    let channel = null;

    function fetchUsers() {
        $.ajax({
            url: '/chat/online',
            method: 'GET',
            success: function(response) {
                // Clear existing messages
                $('#users').empty();

                response.users.forEach(function(user) {
                    var messageHTML = `
                            <a href="#" data-id="${user.chat_id}">
                            <li>
                            <img src="${user.picture_url}" alt="" width="55" height="55">
                            <div>
                                <h2>${user.name}</h2>
                                <h2>ChatID : ${user.chat_id}</h2>
                                <h3>
                                    <span class="status green"></span>
                                    online
                                </h3>
                            </div>
                            </li>
                            </a>
                        `;
                    $('#users').append(messageHTML);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    function fetchMessages(globalVar) {
        if (globalVar == null) return;
        // console.log(globalVar);
        $.ajax({
            url: '/chat/' + globalVar,
            method: 'GET',
            success: function(response) {
                // Clear existing messages
                $('#chat').empty();
                $('#header').empty();
                // console.log(response);

                response.messages.forEach(function(message) {
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
                var header = `
                        <img src="${response.pic}" alt="" width="55" height="55">
                        <div>
                            <h2>${response.name}</h2>
                            <h3>Online</h3>
                        </div>
                    `;
                $('#header').append(header);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    function sendMessage() {
        var message = $('#messageInput').val();
        if (message === '') return;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // AJAX request to send the message
        $.ajax({
            url: '/chat/' + globalVar,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                message: message
            },
            success: function(response) {
                console.log('Message sent successfully:', response);
                $('#messageInput').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', error);
            }
        });
    }

    $('#users').on('click', 'a', function(event) { // 'a' -> any
        event.preventDefault();
        var chatId = $(this).data('id');

        globalVar = chatId;
        if (channel) {
            channel.unbind(); // Unbind previous bindings
            channel.unsubscribe();
        }
        channel = pusher.subscribe('chat.' + chatId);
        channel.bind('new-message', function(data) {
            fetchMessages(chatId);
        });
        fetchMessages(chatId);
    });

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

    // Fetch on page load
    fetchUsers();
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<link rel="stylesheet" href="{{ asset('chatbox.css') }}">
@endpush