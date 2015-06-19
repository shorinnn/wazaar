@extends('layouts.default')
@section('content')	

<section class="container-fluid">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
            	<form>
                	<div>
                    	<label></label>
                    	<input type="text">
                    </div>
                    <div>
                    	<label></label>
                        <select>
                        
                        </select>
                    </div>
                    <div>
                    	<label></label>
                        <select>
                        
                        </select>
                    </div>
                    <div class="difficulty-levels">
                        <div class="level-buttons-container">
                            <a href="#" class="beginner level-buttons">Beginner</a>
                            <a href="#" class="advanced level-buttons">Advanced</a>
                            <a href="#" class="intermediate level-buttons">Intermediate</a>
                        </div>
                    </div>
                    <div>
                    	<button class="blue-button large-button">CREATE COURSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop