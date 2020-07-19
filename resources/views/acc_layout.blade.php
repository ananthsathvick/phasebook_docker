@extends('layouts.all_pages')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-11">
            <div id="cover-pic-div">
                <h4 id="pro-name">{{$user->name}}</h4>
                <img id="cover-pic" src="@if($user->cover_pic  == NULL){{ asset('img/def_cover.jpeg') }}@else {{asset('img/'. str_replace(' ', '_', strtolower($user->name)).'/'.$user->cover_pic)}} @endif" class="" alt="Cover pic">
                <div id="pro-pic-div">
                    <img src="@if($user->pro_pic  == NULL)
                                @if($user->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower($user->name)).'/'.$user->pro_pic)}} 
                            @endif" alt="..." class="rounded-circle bottom-left">

                </div>
                <div class="bottom-right d-inline">
                    <button type="button" class="btn btn-secondary btn-sm" id="send_frnd_req">
                        @if($code == 3)
                        <i class="fas fa-user-plus"></i> Add Friend
                        @elseif($code == 1)
                        <i class="fas fa-user-plus"></i> Accept Friend Request
                        @elseif($code == 0)
                        <i class="fas fa-user-plus"></i> Friend Request Sent
                        @else
                        <i class="fas fa-check"></i> Friends
                        @endif
                    </button>

                    <button type="button" @if($code !=2) style="display: none;" @endif class="btn btn-secondary btn-sm" id="msg_btn"><i class="fab fa-facebook-messenger"></i> Message</button>


                </div>
            </div>
            <div class="card text-center border-top-0 border-fb-col">
                <div class="card-body p-0">

                    <div class="row justify-content-center">
                        <a href="/account/{{$user->uid}}" class="text-decoration-none">
                            <div class="col-auto  border-right border-left border-fb-col  py-2 px-3">
                                <div class="mx-4">
                                    Timeline
                                </div>
                            </div>
                        </a>
                        <!-- <div class="col-auto border-right  border-fb-col p-2">
                            <div class="mx-4">
                                About
                            </div>
                        </div> -->
                        <a href="/account/{{$user->uid}}/friends" class="text-decoration-none">
                            <div class="col-auto  border-right  border-fb-col p-2">
                                <div class="mx-4">
                                    Friends
                                </div>
                            </div>
                        </a>
                        <div class="col-auto  border-right  border-fb-col p-2">
                            <div class="mx-4">
                                Photos
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('acc_con')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.liked_by').click(function() {
                var iid = $(this).attr('id');
                var pid = iid.split('_')[1];
                console.log(pid);
                $.ajax({
                    type: 'POST',
                    url: '/liked_by',
                    data: {
                        pid: pid
                    },
                    success: function(data) {
                        console.log('#modal_body_' + pid);
                        $('#modal_body_' + pid).html(data);
                    }
                });
            });

    $('.getc').click(function() {
        var iid = $(this).attr('id');
        var pid = iid.split('_')[1];
        console.log(pid);
        $.ajax({
            type: 'POST',
            url: '/get_comment',
            data: {
                pid: pid
            },
            success: function(data) {
                console.log('#app_' + pid);
                $('#app_' + pid).html(data);
            }
        });
    });

    $('.comment').keypress(function(e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
            var com = $(this).val();
            var pid = $(this).attr('id');
            $(this).val('');
            $.ajax({
                type: 'POST',
                url: '/comment',
                data: {
                    from: '{{ Auth::id() }}',
                    pid: pid,
                    comment: com
                },
                success: function(data) {

                    pid = pid.split("_")[1];
                    console.log('#app_' + pid);
                    $('#app_' + pid).html(data);
                }
            });

        }
    });

    $('.like,.dis-like').click(function() {
        var pid = $(this).attr('val');
        //console.log($id);
        $pos = $(this);
        $chld = $(this).children("i");
        if ($pos.hasClass('like')) {
            $.ajax({
                type: 'POST',
                url: '/like',
                data: {
                    from: '{{ Auth::id() }}',
                    pid: pid
                },
                success: function(data) {
                    console.log(data);
                    $chld.removeClass();
                    $chld.addClass('fas fa-thumbs-up');
                    $pos.css('color', 'dodgerblue');
                    // $pos.removeClass('like');
                    // $pos.attr("class", "dis-like");
                    $pos.toggleClass('like dis-like');
                    $('#' + pid).html(parseInt($('#' + pid).html(), 10) + 1)

                }
            });

        } else {
            $.ajax({
                type: 'POST',
                url: '/dis_like',
                data: {
                    from: '{{ Auth::id() }}',
                    pid: pid
                },
                success: function(data) {
                    console.log(data);
                    $chld.removeClass();
                    $chld.addClass('far fa-thumbs-up');
                    $pos.css('color', 'black');

                    // $pos.removeClass('dis-like');
                    // $pos.attr("class", "like");
                    $pos.toggleClass('like dis-like');
                    $('#' + pid).html(parseInt($('#' + pid).html(), 10) - 1);
                }
            });

        }

    });

    $('#send_frnd_req').click(function() {
        @if($code == 3)

        $.ajax({
            type: 'POST',
            url: '/send_freq',
            data: {
                from: '{{ Auth::id() }}',
                to: '{{$user->uid}}'
            },
            success: function(data) {
                //$("#msg").html(data.msg);
                console.log(data);
                if (JSON.parse(data) == "success") {

                    $('#send_frnd_req').html('<i class="fas fa-user-plus"></i> Friend Request Sent');

                    //console.log($(this));
                }
            }
        });
        @elseif($code == 1)
        $.ajax({
            type: 'POST',
            url: '/accept_freq',
            data: {
                to: '{{ Auth::id() }}',
                from: '{{$user->uid}}'
            },
            success: function(data) {
                //$("#msg").html(data.msg);
                console.log(data);
                if (JSON.parse(data) == "success") {

                    $('#send_frnd_req').html('<i class="fas fa-check"></i> Friends');
                    $('#msg_btn').show();

                    //console.log($(this));
                }
            }
        });

        @endif

    });
</script>
@endsection