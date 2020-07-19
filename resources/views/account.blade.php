@extends('acc_layout')

@section('acc_con')
<div class="container mt-3">
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <i class="fas fa-globe-americas border-fb-col"></i>
                            <h6 class="d-inline"> Intro</h6>
                        </div>
                    </div>
                    <div class="row justify-content-center my-2">
                        <div class="col-auto text-center">
                            <div> {{$user->bio}} </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row mb-3">
                        <div class="col-auto">
                            <i class="fas fa-briefcase"></i>
                            <div class="d-inline">{{$user->work}}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap"></i>
                            <div class="d-inline"> {{$user->study}}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="d-inline">{{$user->dob}}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-auto">
                            <i class="fas fa-venus-mars"></i>
                            <div class="d-inline"> {{$user->gender}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <i class="fas fa-image" style="color: #a5d950;"></i>
                            <h6 class="d-inline"> Photos</h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <div class="grid">
                                @foreach($posts as $post)
                                <a href="#pos_{{$post->pid}}">
                                    <div><img src="{{ asset('img/'.str_replace(' ','_',strtolower($post->name)).'/'.$post->post_image) }}" class="" alt="Cover pic" style="object-fit:contain"></div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <i class="fas fa-user-friends" style="color: #f60c6b"></i>
                            <h6 class="d-inline"> Friends</h6>
                            <div class="d-inline text-muted">{{count($users_frnd)}}</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <ul class="image-list-small m-0">
                                @foreach($users_frnd as $u)
                                <li>
                                    <a href="/account/{{$u->uid}}" style="background-image: url(@if($u->pro_pic  == NULL){{ asset('img/main.png') }}@else {{asset('img/'. str_replace(' ', '_', strtolower($u->name)).'/'.$u->pro_pic)}} @endif)"></a>
                                    <div class="details">
                                        <h3><a href="/account/{{$u->uid}}">{{$u->name}}</a></h3>

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-muted text-center mt-2">Phasebook © {{date("Y")}}
            </div>

        </div>
        <div class="col-sm-6">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(count($posts) == 0)
            <div class="text-muted text-center mt-3">No posts yet</div>
            @endif
            @foreach($posts as $post)
            <div class="card my-3" id="pos_{{$post->pid}}">
                <div class="card-body pb-0">
                    <!-- <div class="card-title"> -->
                    <div class="row mb-1">
                        <div class="col-sm-2 mx-w-14">
                            <img src="@if($post->pro_pic  == NULL)
                                @if($post->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower($post->name)).'/'.$post->pro_pic)}} 
                            @endif" class="rounded mx-auto d-block img-fluid cr-pos-img" alt="Image">
                        </div>
                        <div class="col-sm pad-lef-0">
                            <a href="/account/{{$post->uid}}">{{$post->name}} </a><br>
                            <div class=" text-muted" style="font-size: 12px">{{$post->created_at}}</div>
                        </div>
                        <div class="col-sm-2">
                            @if(Auth::user()->uid == $post->uid)
                            <div class="btn-group offset-md-4">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{route('del.post',[$post->pid])}}">Delete Post</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- </div> -->
                    <p>{{$post->post_caption}}</p>
                    <img src="{{ asset('img/'.str_replace(' ','_',strtolower($post->name)).'/'.$post->post_image) }}" class="img-fluid" alt="Responsive image">

                    <div type="button" class="liked_by underline" id="lkedby_{{$post->pid}}" data-toggle="modal" data-target="#like_count_{{$post->pid}}"><i class="far fa-thumbs-up"></i> <span id="{{$post->pid}}"> @if($post->like_count!=NULL) {{$post->like_count}}@else 0 @endif</span></div>

                    <!-- Modal -->
                    <div class="modal fade" id="like_count_{{$post->pid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Liked by</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modal_body_{{$post->pid}}">
                                    ...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">

                        @if($post->fd == NULL)
                        <div class="col justify-content-center text-center like" type="button" val="{{$post->pid}}">
                            <i class="far fa-thumbs-up"></i> Like
                            @else
                            <div class="col justify-content-center text-center dis-like" type="button" val="{{$post->pid}}" style="color: dodgerblue;">
                                <i class="fas fa-thumbs-up"></i> Like
                                @endif
                            </div>
                            <div class="col text-center getc" type="button" id="getc_{{$post->pid}}">
                                <i class="far fa-comment-alt"></i> Comment
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-sm-2 mx-w-14 ">
                                <img src="@if(Auth::user()->pro_pic  == NULL)
                                @if(Auth::user()->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower(Auth::user()->name)).'/'.Auth::user()->pro_pic)}} 
                            @endif" class="rounded mx-auto d-block img-fluid cr-pos-img" alt="Image">
                            </div>
                            <div class="col-sm pad-lef-0">
                                <div class="input-group">
                                    <input class="form-control cr-pos-img bg-com comment" id="comm_{{$post->pid}}" aria-label="With textarea" placeholder="Comment..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div id="app_{{$post->pid}}"></div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>

</script>
@endsection