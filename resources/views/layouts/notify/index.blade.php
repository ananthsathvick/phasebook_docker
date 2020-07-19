@if(count($users) == 0)
<div class="text-muted">No Likes Yet !</div>
@else
@foreach($users as $u)
<a href="/profile/#pos_{{$u->post_id}}" class="text-decoration-none">
    <div @if($u->is_read == 1) style="background-color: #c7cbd4;" @endif>
        <div class="row">
            <div class="col-sm-2 m-2">
                <img src="@if($u->pro_pic  == NULL)
                                @if($u->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower($u->name)).'/'.$u->pro_pic)}} 
                            @endif" class="rounded mx-auto img-fluid cr-pos-img" alt="Image">
            </div>
            <div class="col-sm p-0">
                {!!$u->notice!!} <br>
            </div>
            <div class="col-sm-3">
                <img src="{{asset('img/'. str_replace(' ', '_', strtolower(Auth::user()->name)).'/'.$u->post_image)}}" class="img-fluid" alt="Image">
            </div>
        </div>
    </div>
</a>
<div class="dropdown-divider m-0"></div>

@endforeach
@endif