<div class='well custom-percentage-{{$customPercentage->id}}'>
    {{ Form::select("course_category_id[$customPercentage->id]", $affiliates, 
                    $customPercentage->affiliate_id, [ 'class' => 'ajax-updatable', 'data-name' => 'affiliate_id',
                    'data-url' => action('CustomPercentagesController@update', $customPercentage->id)

                    ] ) }}

    <input type='number' min="0" max="68" class="ajax-updatable"
           data-url="{{action('CustomPercentagesController@update', $customPercentage->id)}}"
           value='{{ $customPercentage->percentage }}' data-name="percentage"
           name='custom_percentage[{{$customPercentage->id}}]' />%

    {{ Form::open(array('action' => ['CustomPercentagesController@destroy', $customPercentage->id], 'method' => 'delete', 
                        'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 
                        'data-delete' => '.custom-percentage-'.$customPercentage->id )) }}
    <button type="submit" name="delete-custom-percentage-{{$customPercentage->id}}" 
            class="delete-button btn btn-danger" data-message="{{ trans('crud/labels.you-sure-want-delete') }}">
        <i class="fa fa-trash-o"></i>
    </button>
    {{ Form::close() }}
</div>
