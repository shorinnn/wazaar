<div id="follow-form">
    @if($instructor!=null)
        @if(Auth::check() && $instructor->followed( Auth::user()->id ) )
            {{ trans('general.you-are-following') }} {{$instructor->first_name}} {{$instructor->last_name}}.
            {{ Form::open( [ 'action' => ['FollowersController@destroy'], 'class' => 'ajax-form inline-block', 
                    'data-callback' => 'replaceElementWithReturned', 'data-replace' => '#follow-form'] ) }}
                <button type="submit" class="follow-button">{{ trans('general.unfollow') }}</button>
                <input type='hidden' name='instructor' value='{{$instructor->id}}' />
                <input type='hidden' name='_method' value='DELETE' />
            {{ Form::close() }}
        @else
            {{ Form::open( [ 'action' => ['FollowersController@store'], 'class' => 'ajax-form inline-block',
                    'data-callback' => 'replaceElementWithReturned', 'data-replace' => '#follow-form'] ) }}
                <button type="submit" class="follow-button">{{ trans('general.follow') }}</button>
                <input type='hidden' name='instructor' value='{{$instructor->id}}' />
            {{ Form::close() }}
        @endif
    @endif
</div>