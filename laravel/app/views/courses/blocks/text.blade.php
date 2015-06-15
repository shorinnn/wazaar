{{ trans('courses/create.additional-lesson-notes') }}

<p class="tip"> {{ trans('courses/create.description-tip') }}</p>

<form method='post' class='ajax-form' action='{{action('BlocksController@saveText', [$block->lesson->id, $block->id])}}'>
    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
    <textarea id='lesson-text-{{ $block->lesson->id }}' name='content' style='width:100%'>{{ $block->content }}</textarea>
</form>