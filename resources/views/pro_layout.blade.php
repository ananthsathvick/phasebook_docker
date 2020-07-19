@extends('layouts.all_pages')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-11">
            <div id="cover-pic-div">
                <img id="cover-pic" src="@if($user->cover_pic  == NULL){{ asset('img/def_cover.jpeg') }}@else {{asset('img/'. str_replace(' ', '_', strtolower(Auth::user()->name)).'/'.$user->cover_pic)}} @endif" class="" alt="Cover pic">
                <div id="pro-pic-div">
                    <img src="@if(Auth::user()->pro_pic  == NULL)
                                @if(Auth::user()->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower(Auth::user()->name)).'/'.Auth::user()->pro_pic)}} 
                            @endif" alt="..." class="rounded-circle bottom-left">
                    <form action="{{ route('upload-pro') }}" method="POST" enctype="multipart/form-data" id="pro_form">
                        @csrf
                        <input type="file" id="inp_pro" name="proimg" onchange="$('#pro_form').submit()" hidden />
                        <button id="edit_pro_btn" type="button" onclick="$('#inp_pro').click();" class="btn btn-light rounded-circle btn-sm"><i class="fas fa-camera"></i></button>
                    </form>
                </div>
                <h4 id="pro-name">{{$user->name}}</h4>
                <form action="{{ route('upload-cover') }}" method="POST" enctype="multipart/form-data" id="cover_form">
                    @csrf
                    <input type="file" id="inp_cover" name="coverimg" onchange="$('#cover_form').submit()" hidden />
                    <button id="edit_cv_btn" type="button" onclick="cover_pic();" class="btn btn-secondary btn-sm "><i class="fas fa-camera"></i> Edit cover pic</button>
                </form>
            </div>
            <div class="card text-center border-top-0 border-fb-col">
                <div class="card-body p-0">

                    <div class="row justify-content-center">
                        <a class="text-decoration-none" href='/profile'>
                            <div class="col-auto  border-right border-left border-fb-col  py-2 px-3 text-decoration-none">
                                <div class="mx-4">
                                    Timeline
                                </div>
                        </a>
                    </div>
                    <!-- <div class="col-auto border-right  border-fb-col p-2">
                            <div class="mx-4">
                                About
                            </div>
                        </div> -->
                    <a href='/friends' class="text-decoration-none">
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
@yield('con')
@endsection