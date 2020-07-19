@extends('layouts.all_pages')

@section('content')
<link href="{{ asset('css/messenger.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
                    @foreach($users as $user)
                    <li class="user" id="{{ $user->uid }}">
                        {{--will show unread count notification--}}
                        @if($user->unread)
                        <span class="pending">{{ $user->unread }}</span>
                        @endif

                        <div class="media">
                            <div class="media-left">
                                <img src="@if($user->pro_pic  == NULL)
                                @if($user->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower($user->name)).'/'.$user->pro_pic)}} 
                            @endif" alt="" class="media-object">
                            </div>

                            <div class="media-body">
                                <p class="name">{{ $user->name }}</p>
                                <p class="email">{{ $user->email }}</p>
                            </div>
                        </div>

                    </li>
                    <div class="dropdown-divider" id="dpdv" style="border-top:1px solid #b4bbc1"></div>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <div id="messages">

            </div>
            <div class="input-text" style="display: none" id="inp_msg">
                <input type="text" name="message" class="submit" id="msg_inp">
            </div>
        </div>




    </div>
</div>
@endsection