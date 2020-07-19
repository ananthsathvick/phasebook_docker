<div>

    @if(count($comm) == 0)
    <div class="text-muted"> No comments ! </div>
    @else
    <div class="hc text-muted container-fluid" type="button">Hide Comments <i class="fas fa-angle-up"></i></div>
    @foreach($comm as $com)
    <div class="row">
        <div class="col-sm-2 mx-w-14 ">
            <img src="@if($com->pro_pic  == NULL)
                        @if($com->gender == 'Male')
                            {{ asset('img/male_default.png') }}
                        @else
                            {{ asset('img/female_default.jpg') }}
                        @endif
                    @else 
                        {{asset('img/'. str_replace(' ', '_', strtolower($com->name)).'/'.$com->pro_pic)}} 
                    @endif" class="rounded mx-auto d-block img-fluid cr-pos-img" alt="Image">
        </div>
        <div class="col-sm-auto border px-4 mb-2" style="border-radius:1.25rem;background-color:#eaebee;width: 16em;word-wrap: break-word;">
            <div class="row">
                <a href="/account/{{$com->uid}}">{{$com->name}}</a>
            </div>
            <div class="row">
                <div>{{$com->comment}}</div>
            </div>
        </div>
    </div>
    <div class="dropdown-divider"></div>
    @endforeach
    @endif
</div>
<script>
    $('.hc').click(function() {
        $(this).parent().hide();

    });
</script>