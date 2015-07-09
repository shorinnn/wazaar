@extends('layouts.default')
@section('content')	
<style>

    </style>
    <div class="container course-categories">
    	<div class="row">
        	<div class="col-md-12">
                <h1 class='icon'>{{ trans('administration.category-groups') }}</h1>    
                
                <ul id='items-list'>
                    @foreach(CategoryGroup::orderBy('order','asc')->get() as $group)
                        {{ View::make('administration.category_groups.group')->with( compact('group') ) }}
                    @endforeach
                </ul>            
            </div>
        </div>
    </div>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12">
                <form method='post' class='ajax-form' id="add-category-form" data-callback='addToList' data-destination='#items-list'
                      action='{{ action('CategoryGroupsController@store') }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                    <div>
                        <input type='text' name='name' placeholder="{{ trans('crud/labels.name') }}" />
                        <button type='submit' class='btn btn-primary'>{{ trans('administration.add-group') }}</button>
                    </div>
                </form>
    		</div>
    	</div>
    </div>

@stop