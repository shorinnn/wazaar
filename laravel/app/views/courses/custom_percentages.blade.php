@extends('layouts.default')
@section('page_title')
    {{ $course->name }} - {{ trans('courses/general.edit') }} -
@stop

@section('content')

<style>
    #save-indicator{
        border:1px solid black;
        background-color:white;
        width:90px;
        height:30px;
        position:fixed;
        top:100px;
        left:-100px;
        text-align: right;
        padding-right: 10px;
    }
</style>

@if (Session::get('success'))
<div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
@if (Session::get('error'))
<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif
<div class="container instructor-course-editor">
	<div class="row">
    	<div class="col-md-12">

        </div>
    </div>
    <div class="row">
              <form method='post' class='ajax-form' id='percentage-form' data-callback='addPercentage'
                action='{{ action('CustomPercentagesController@store') }}'>
                  <input type='hidden' name='_token' value='{{ csrf_token() }}' />
                  <input type='hidden' name='course_id' value='{{ $course->id }}' />
                  <button type='submit' class='btn'>Add New</button>
            </form>
        <div class="col-md-12 percentage-holder">
            
      
            
            
            @foreach($course->affiliateCustomPercentages as $customPercentage)
                {{ View::make('courses.custom_percentage')->with(compact('customPercentage', 'affiliates')) }}
            @endforeach
        </div>

    </div>
</div>
</div>
</div>


@stop

@section('extra_js')
<script>
    function addPercentage(json){
        var destination = '.percentage-holder';
        var perc = json.html;
        $(destination).append(perc);
        restoreSubmitLabel( $('#percentage-form') );
    }
</script>
@stop