@extends('layouts.default')

@section('content')
<style>
    .inline-block{
        display:inline-block;
    }
	    .overall-content-wrap{
	        background-color: #ebeced;
	    }

</style>

    @if($wishlist->count() == 0)
        <h1>{{ trans('general.no-items-on-wishlist') }}</h1>
    @else
        <h1>{{$student->first_name}} {{$student->last_name}} {{ trans('general.wishlist') }}:</h1>
        @foreach($wishlist as $item)
        <div id="wishlist-{{$item->id}}"> 
            
            <a href='{{action( 'CoursesController@show', $item->course->slug )}}'>{{ $item->course->name }}</a> 
            - ¥{{ number_format($item->course->cost(), Config::get('custom.currency_decimals')) }}
            
        @if(Auth::check() && Auth::user()->id == $student->id)
            {{ Form::open(array('action' => ['WishlistController@destroy', $item->id], 'method' => 'delete', 
                    'class' => 'ajax-form inline-block', 'data-callback' => 'deleteItem', 'data-delete' => '#wishlist-'.$item->id )) }}
                <button type="submit" name="delete-wishlist-item-{{$item->id}}" class="btn btn-danger btn-mini delete-button" 
                        data-message="{{ trans('crud/labels.you-sure-want-delete') }}"><i class="fa fa-trash"></i></button>
            {{ Form::close() }}
        @endif
        
        </div>
        @endforeach
    @endif
   
@stop