<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)
            <li class="message clearfix">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                    <p>{{ $message->message }}</p>
                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }} <span class="text-right">@if($message->is_read)<i class="fas fa-check-double"></i>@else <i class="fas fa-check"></i>@endif</span></p>
                </div>
            </li>
        @endforeach
    </ul>
</div>

