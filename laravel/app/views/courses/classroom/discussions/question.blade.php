<div style='padding:10px; margin-bottom: 5px;' class='question-entry'>

    <a href='{{action( 'DiscussionsController@show', $discussion->id) }}' data-url='{{action( 'DiscussionsController@show', $discussion->id) }}'
       data-callback='updateHTML' class='link-to-remote' data-property='html' data-target='.lesson-questions-replies'
       style='font-size:16px; color: rgb(0, 153, 255); padding: 3px; font-weight: bold'> {{$discussion->title}} </a>
    <div class='pull-right' style='font-size: 12px'>
        <span class='discussion-votes-{{$discussion->id}}'>{{ (int)$discussion->upvotes }}</span>
        <a href='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'up' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
           data-url='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'up' ] ) }}' data-target='.discussion-votes-{{$discussion->id}}'>
            <i class="fa fa-angle-up"></i>
        </a> |
        <a href='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'down' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
           data-url='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'down' ] ) }}'data-target='.discussion-votes-{{$discussion->id}}'>
            <i class="fa fa-angle-down"></i>
        </a>
    </div>
       
    <p style='font-size: 12px; padding: 3px'>
        @if( $discussion->replies->count() > 0)
            {{$discussion->replies->count()}} responses
        @else
            Be first to respond
        @endif
    </p>
</div>