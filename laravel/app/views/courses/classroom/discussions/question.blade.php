<div class='rows questions-box question-entry'>
    <a href='{{action( 'DiscussionsController@show', $discussion->id) }}' data-url='{{action( 'DiscussionsController@show', $discussion->id) }}'
       data-callback='toggleRightBar' data-pre-function = 'toggleRightBar' class='link-to-remote' data-property='html' data-target='.right-slide-menu'
       data-loading-container='.right-slide-menu'> 

            <span class="question-title">
                    {{$discussion->title}} 
            </span>
           <div class='pull-right' style='font-size: 12px'>
                <span class='discussion-votes discussion-votes-{{$discussion->id}}'>{{ (int)$discussion->upvotes }}</span>
                <span href='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'up' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                   data-url='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'up' ] ) }}' data-target='.discussion-votes-{{$discussion->id}}'>
                    <i class="fa fa-angle-up"></i>
                </span><!--  |
                <a href='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'down' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                   data-url='{{ action( 'DiscussionsController@vote',[ $discussion->id, 'down' ] ) }}' data-target='.discussion-votes-{{$discussion->id}}'>
                    <i class="fa fa-angle-down"></i>
                </a>-->
            </div>

            <span class="replies-count">
                @if( $discussion->replies->count() > 0)
                    {{$discussion->replies->count()}} responses
                @else
                    Be first to respond
                @endif
            </span>
        </a>
</div>