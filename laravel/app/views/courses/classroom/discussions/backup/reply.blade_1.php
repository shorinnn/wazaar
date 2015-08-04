<div>
    <div class='row' style='border:1px solid silver; background-color:white; margin:0px; padding: 5px'>
        <div class='col-lg-2'>
            <img  style='width:100%' src='{{ $reply->student->commentPicture('student') }}' />
        </div>
        <div class='col-lg-10'>
            <div style='font-size:12px; font-weight:bold; margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px solid silver;'>
                {{ $reply->student->fullName() }}
                {{ $reply->created_at->diffForHumans() }}
                <div class='pull-right'>
                    <span class='reply-votes-{{$reply->id}}'>{{ (int)$reply->upvotes }}</span>
                    <a href='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'up' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                       data-url='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'up' ] ) }}' data-target='.reply-votes-{{$reply->id}}'>
                        <i class="fa fa-angle-up"></i>
                    </a> |
                    <a href='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'down' ] ) }}' class='link-to-remote' data-callback='updateHTML' data-property='votes'
                       data-url='{{ action( 'DiscussionRepliesController@vote',[ $reply->id, 'down' ] ) }}'data-target='.reply-votes-{{$reply->id}}'>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div>
            {{ $reply->content }}
        </div>
        <br class='clearfix' />&nbsp;
    </div>
</div>
