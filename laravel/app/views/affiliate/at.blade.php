@extends('layouts.default')

@section('page_title')
    Accept Terms - 
@stop

@section('content')	
<style>
.checkbox-buttons .checkbox-item{
	overflow: visible;
}

.checkbox-buttons .checkbox-item span{
	font-size: 16px;
	margin-left: 2px;
}

.checkbox-buttons .checkbox-item label{
	position: relative;
	top: 3px;
}

</style>
<section class="container text-center">
    <div style='border:1px solid silver; padding:10px; margin:20px; height:400px; overflow-y: scroll'>
        @include('affiliate.terms')
    </div>
    {{ Form::open( ['AffiliateController@doAcceptTerms' ] ) }}
        <div class="checkbox-buttons text-center" style="display: block; float:none">
            <div class="row no-margin">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="checkbox-item text-center no-padding">
                        <div class="checkbox-checkbox checkbox-checked no-float">
                          <input id="checkbox-1" autocomplete="off" type="checkbox" name='accept' value='1' />                        
                          <label for="checkbox-1" class="small-checkbox">
                          </label>
                          <span>{{ trans('general.i-agree') }}</span>
                        </div>  
                      </div>
                </div>
                <div class="col-lg-5"></div>
            </div>
            <div class="clearfix"></div>
            
        </div>
            <button type='submit' class='large-button blue-button margin-bottom-20'>{{ trans('general.accept') }}</button>
        {{ Form::close() }}
</section>

@stop