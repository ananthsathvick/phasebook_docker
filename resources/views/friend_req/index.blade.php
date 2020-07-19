<div>
    @if(count($users) == 0)
    Send Some Requests Niggah!
    @else

    @foreach($users as $user)

    <div class="row">
        <div class="col-sm-2 m-2">
            <img src="@if($user->pro_pic  == NULL)
                                @if($user->gender == 'Male')
                                {{ asset('img/male_default.png') }}
                                @else
                                {{ asset('img/female_default.jpg') }}
                                @endif
                              @else 
                              {{asset('img/'. str_replace(' ', '_', strtolower($user->name)).'/'.$user->pro_pic)}} 
                            @endif" class="rounded mx-auto img-fluid cr-pos-img" alt="Image">
        </div>
        <div class="col-auto p-0">
            <a class="dropdown-item" href="/account/{{$user->uid}}">{{$user->name}}</a>
        </div>
        <div class="col-auto p-0 mr-1 ml-auto">
            <button type="button" class="btn btn-primary acc" id="accpt_{{$user->uid}}">Accept</button>
        </div>
        <div class="col-auto p-0 mr-3">
            <button type="button" class="btn btn-danger delreq" id="delfreq_{{$user->uid}}">Delete</button>
        </div>
    </div>
    <div class="dropdown-divider"></div>

    @endforeach

    @endif
</div>
<script>
    $('.acc').click(function() {
        var id = $(this).attr('id').split("_")[1];
        $.ajax({
            type: 'POST',
            url: '/accept_freq',
            data: {
                to: '{{ Auth::id() }}',
                from: id
            },
            success: function(data) {
                //$("#msg").html(data.msg);
                console.log(data);
                // if (JSON.parse(data) == "success") {

                //     $('#send_frnd_req').html('<i class="fas fa-check"></i> Friends');
                //     $('#msg_btn').show();
                window.location.reload(true);

                //console.log($(this));

            }
        });
    });



    $('.delreq').click(function() {
        var id = $(this).attr('id').split("_")[1];
        $.ajax({
            type: 'POST',
            url: '/delete_freq',
            data: {
                to: '{{ Auth::id() }}',
                from: id
            },
            success: function(data) {
                //$("#msg").html(data.msg);
                console.log(data);
                // if (JSON.parse(data) == "success") {

                //     $('#send_frnd_req').html('<i class="fas fa-check"></i> Friends');
                $('#get_frq').click();


                //console.log($(this));

            }
        });
    });
</script>