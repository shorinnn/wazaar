<table class="table table-bordered table-striped">
    <thead>
    <th>From</th>
    <th>Message</th>
    <th>Sent</th>
</thead>
<tbody>
    @foreach($messages as $message)
    @if( $message->isUnread( Auth::user()->id) )
        <tr class="message-row message-row-{{$message->id}} bolded">
    @else
        <tr class='message-row message-row-{{$message->id}}'>
    @endif
        <td>
            <a href='#' id="video-link-{{$message->id}}" class='load-message' data-row-id='message-content-{{$message->id}}' data-target='#message-content-{{$message->id}} > td'
                   data-url='{{action('PrivateMessagesController@thread', [$message->id] )}}'>                               
                
            {{ $message->_sender() }}</a>
        </td>
        <td>
            <a href='#' id="video-link-{{$message->id}}" class='load-message' data-row-id='message-content-{{$message->id}}' data-target='#message-content-{{$message->id}} > td'
                   data-url='{{action('PrivateMessagesController@thread', [$message->id] )}}'>  
            {{{ Str::limit($message->content, 20) }}}
            </a>
        </td>
        <td>
            <a href='#' id="video-link-{{$message->id}}" class='load-message' data-row-id='message-content-{{$message->id}}' data-target='#message-content-{{$message->id}} > td'
                   data-url='{{action('PrivateMessagesController@thread', [$message->id] )}}'>  
                {{ $message->created_at->diffForHumans() }}
            </a>
        </td>
    </tr>
    
    @endforeach
</tbody>
</table>
<div class="text-center load-remote" data-target='.ajax-content' data-load-method="fade">
    {{ $messages->links() }}
</div>