@extends('layouts.default')
@section('content')	
<style>

    </style>
    <div class="container course-categories">
    	<div class="row">
        	<div class="col-md-12">
                <h1 class='icon'>Course Difficulties</h1>    
                
                <ul id='items-list'>
                    @foreach(CourseDifficulty::all() as $difficulty)
                        {{ View::make('administration.course_difficulties.difficulty')->with( compact('difficulty') ) }}
                    @endforeach
                </ul>            
            </div>
        </div>
    </div>
    <div class="container">
    	<div class="row">
        	<div class="col-md-12">
                <form method='post' class='ajax-form' id="add-difficulty-form" data-callback='addToList' data-destination='#items-list'
                      action='{{ action('CourseDifficultiesController@store') }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                    <div>
                        <input type='text' name='name' placeholder="{{ trans('name') }}" />
                        <button type='submit' class='btn btn-primary'>{{ trans('crud/labels.add_difficulty') }}</button>
                    </div>
                </form>
    		</div>
    	</div>
    </div>

@stop