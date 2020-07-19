<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8>
    <meta name=" viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.min.js') }}" defer></script>-->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/front.css') }}" rel="stylesheet">
    <link href="{{ asset('css/emojionearea.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f90d346ab1.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{asset('js/front.js')}}"></script>
    <script src="{{asset('js/emojionearea.min.js')}}"></script>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-nav shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline ml-2">

                            <div class="ui-widget">

                                <input type="text" class="form-control-sm search-inp" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" id="user">
                            </div>
                            <div class="input-group-append">
                                <button class="btn search btn-sm" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                            <div id="userList">
                            </div>

                        </form>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">








                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item" style="border-right: solid;border-right-width: medium;border-radius: 20px;">
                            <a class="nav-link" href="/profile">{{ preg_split('/[\s,]+/',Auth::user()->name)[0] }}</a>
                        </li>

                        <li class="nav-item" style="border-right: solid;border-right-width: medium;border-radius: 20px;">
                            <a class="nav-link" href="/home">Home</a>
                        </li>

                        <li class="nav-item">
                            <div class="dropdown">
                                <a class="nav-link btn dropdown-toggle" id="get_frq" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-user-friends"></i><sup class="border-0 rounded-circle bg-danger" style="padding: 0px 2px;" id="pend_freq"></sup></a>
                                <div class="dropdown-menu dropdown-menu-right scrollable-menu" aria-labelledby="get_frq" id="friend" style="width:30em;">

                                </div>

                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/messenger"><i class="fab fa-facebook-messenger"></i><sup class="border-0 rounded-circle bg-danger" style="padding: 0px 2px;" id="pend_msg"></sup></a>
                        </li>

                        <li class="nav-item" style="border-right: solid;border-right-width: medium;border-radius: 20px;">
                            <div class="dropdown" id="noti_dw">
                                <a class="nav-link btn dropdown-toggle" id="get_notify" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="fas fa-bell"></i><sup class="border-0 rounded-circle bg-danger" style="padding: 0px 2px;" id="pend_notify"></sup></a>
                                <div class="dropdown-menu dropdown-menu-right scrollable-menu" aria-labelledby="get_notify" id="notify" style="width:24em">


                                </div>

                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 my-4">
            @yield('content')
        </main>
    </div>

    <!-- Messanger script -->
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

    <script type="text/javascript" charset="utf-8">
        var receiver_id = '';
        var my_id = "{{ Auth::id() }}";
        $(document).ready(function() {
            $.ajax({
                type: "post",
                url: "/get_frq_pen", // need to create this route
                data: {
                    id: "{{Auth::id()}}"
                },
                success: function(data) {
                    //console.log(data);
                    $('#pend_freq').html(data[0]);
                    if (data[0] == 0) {
                        $('#pend_freq').hide();
                    }
                    $('#pend_notify').html(data[1]);
                    if (data[1] == 0) {
                        $('#pend_notify').hide();
                    }
                    $('#pend_msg').html(data[2]);
                    if (data[2] == 0) {
                        $('#pend_msg').hide();
                    }

                }
            });

            // request permission on page load
            // document.addEventListener('DOMContentLoaded', function() {
            if (Notification.permission !== "granted")
                Notification.requestPermission().then(function(permission) {
                    console.log('permiss', permission)
                });
            // });

            function notifyMe(fname, message) {
                // console.log("1");
                if (!Notification) {
                    alert('Desktop notifications not available in your browser. Try Chromium.');
                    //  console.log("2");
                    return;
                }

                if (Notification.permission !== "granted") {
                    Notification.requestPermission().then(function(permission) {
                        // If the user accepts, let's create a notification
                        if (permission === "granted") {
                            var notification = new Notification('Messege from ' + fname, {
                                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                                body: message,
                            });

                            notification.onclick = function() {
                                //            console.log("5");
                                window.open("http://88a17fb8.ngrok.io/messenger");
                            };
                        }
                    });
                    //  console.log("3");
                } else {
                    //  console.log("4");
                    var notification = new Notification('Messege from ' + fname, {
                        icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                        body: message,
                    });

                    notification.onclick = function() {
                        //        console.log("5");
                        window.open("http://88a17fb8.ngrok.io/messenger");
                    };
                    //   console.log("6");
                }
                //  console.log("7");

            }

            $("#msg_inp").emojioneArea();
            // ajax setup form csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-Type': 'text/html; charset=utf-8'
                }
            });

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = false;

            var pusher = new Pusher('a8ceda3b313fecc81569', {
                cluster: 'ap2',
                forceTLS: true
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                // alert(JSON.stringify(data));

                if (my_id == data.from) {
                    $('#' + data.to).click();

                } else if (my_id == data.to) {
                    notifyMe(data.fname, data.message);
                    if (receiver_id == data.from) {
                        // if receiver is selected, reload the selected user ...
                        $('#' + data.from).click();
                    } else {

                        // if receiver is not seleted, add notification for that user
                        var pending = parseInt($('#' + data.from).find('.pending').html());

                        if (pending) {
                            $('#' + data.from).find('.pending').html(pending + 1);
                        } else {
                            $('#' + data.from).append('<span class="pending">1</span>');
                        }
                        
                        var tot = $('#pend_msg').html();
                        if (tot == 0) {
                            $('#pend_msg').show();
                        }
                        tot = parseInt(tot) + 1;
                        $('#pend_msg').html(tot);

                        
                    }
                }
            });

            $('.user').click(function() {
                $('.user').removeClass('active');
                $(this).addClass('active');
                $(this).find('.pending').remove();
                $('#inp_msg').show();

                receiver_id = $(this).attr('id');
                $.ajax({
                    type: "get",
                    url: "message/" + receiver_id, // need to create this route .. created
                    data: "",
                    cache: false,
                    success: function(data) {
                        $('#messages').html(data);
                        scrollToBottomFunc();
                    }
                });
            });

            $(document).on('keyup', '.emojionearea-editor', function(e) {
                var message = $(this).html().replace(/<img\s+(?=(?:[^>]*?\s)?class="[^">]*emojione)(?:[^>]*?\s)?alt="([^"]*)"[^>]*>(?:[^<]*<\/img>)?/gi, "$1");
                console.log(message);


                // check if enter key is pressed and message is not null also receiver is selected
                if (e.keyCode == 13 && message != '' && receiver_id != '') {
                    $(this).text(''); // while pressed enter text box will be empty

                    var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                    $.ajax({
                        type: "post",
                        url: "message", // need to create this post route
                        contentType: 'application/x-www-form-urlencoded;charset=utf-32',
                        data: datastr,
                        cache: false,
                        success: function(data) {

                        },
                        error: function(jqXHR, status, err) {},
                        complete: function() {
                            scrollToBottomFunc();

                        }
                    })
                }
            });
        });

        // make a function to scroll down auto
        function scrollToBottomFunc() {
            $('.message-wrapper').animate({
                scrollTop: $('.message-wrapper').get(0).scrollHeight
            }, 50);
        }
        $('#get_frq').click(function() {
            $.ajax({
                type: "post",
                url: "/get_frq", // need to create this route
                data: {
                    id: "{{Auth::id()}}"
                },
                success: function(data) {
                    $('#friend').html(data);
                    $('#pend_freq').hide();
                }
            });
        });

        $('#get_notify').click(function() {
            $.ajax({
                type: "post",
                url: "/get_notify", // need to create this route
                data: {
                    id: "{{Auth::id()}}"
                },
                success: function(data) {
                    $('#notify').html(data);
                    $('#pend_notify').hide();
                }
            });
        });

        Pusher.logToConsole = false;

        var pusher_f = new Pusher('a8ceda3b313fecc81569', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel_f = pusher_f.subscribe('friend_req');
        channel_f.bind('req_sent', function(data) {
            // alert(JSON.stringify(data));

            if (my_id == data.to) {
                if (!Notification) {
                    alert('Desktop notifications not available in your browser. Try Chromium.');
                    //  console.log("2");
                    return;
                }

                if (Notification.permission !== "granted") {
                    Notification.requestPermission().then(function(permission) {
                        // If the user accepts, let's create a notification
                        if (permission === "granted") {
                            var notification = new Notification('New friend Request From ' + data.from, {
                                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                                body: "Accept them nibba",
                            });

                            notification.onclick = function() {
                                //            console.log("5");
                                window.open("http://88a17fb8.ngrok.io/messenger");
                            };
                        }
                    });
                    //  console.log("3");
                } else {
                    //  console.log("4");
                    var notification = new Notification('New friend Request From ' + data.from, {
                        icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                        body: "Accept them nibba",
                    });

                    notification.onclick = function() {
                        //        console.log("5");
                        window.open("http://88a17fb8.ngrok.io/messenger");
                    };
                    //   console.log("6");
                }
                if ($('#friend').hasClass('show')) {
                    // if receiver is selected, reload the selected user ...
                    $('#get_frq').click();
                    $('#get_frq').click();
                } else {

                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#pend_freq').html());
                    $('#pend_freq').show();
                    $('#pend_freq').html(pending + 1);

                }
            }
        });









        Pusher.logToConsole = false;

        var pusher_lkd = new Pusher('a8ceda3b313fecc81569', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel_lkd = pusher_lkd.subscribe('notify');
        channel_lkd.bind('noti', function(data) {
            // alert(JSON.stringify(data));

            if (my_id == data.to) {
                if (!Notification) {
                    alert('Desktop notifications not available in your browser. Try Chromium.');
                    //  console.log("2");
                    return;
                }

                if (Notification.permission !== "granted") {
                    Notification.requestPermission().then(function(permission) {
                        // If the user accepts, let's create a notification
                        if (permission === "granted") {
                            var notification = new Notification(data.from + ((data.like == 0) ? " Commented on your post" : " Liked your post"), {
                                icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                                body: data.note,
                            });

                            notification.onclick = function() {
                                //            console.log("5");
                                window.open("http://localhost/profile#pos_" + data.pid);
                            };
                        }
                    });
                    //  console.log("3");
                } else {
                    //  console.log("4");
                    var notification = new Notification(data.from + ((data.like == 0) ? " Commented on your post" : " Liked your post"), {
                        icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
                        body: data.note,
                    });

                    notification.onclick = function() {
                        //        console.log("5");
                        window.open("http://localhost/profile#pos_" + data.pid);
                    };
                    //   console.log("6");
                }
                if ($('#notify').hasClass('show')) {
                    // if receiver is selected, reload the selected user ...
                    $('#get_notify').click();
                    $('#get_notify').click();
                } else {

                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#pend_notify').html());
                    $('#pend_notify').show();
                    $('#pend_notify').html(pending + 1);

                }
            }
        });
    </script>

</body>

</html>