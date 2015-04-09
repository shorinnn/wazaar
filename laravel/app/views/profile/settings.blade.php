@extends('layouts.default')

@section('page_title')
    {{trans('site/menus.settings')}} - 
@stop

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="well margin-top-15">
                <div class="row">
                    <div class="col-md-7">
                        <h3>{{trans('site/menus.settings')}}</h3>
                    </div>
                </div>
                
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif
                
                {{ Form::open( [ 'action'=> ['ProfileController@updateSettings'], 'method' => 'PUT', 'data-parsley-validate' => 'true',
                        'class' => 'ajax-form', 'data-callback' =>'passUpdated' ] ) }}
                    <div class="form-group">
                        <input type="password" name="old_password" class="form-control" placeholder="{{ trans('crud/labels.old-password') }}"
                       required />
                    </div>
                    <div class="form-group">
                        <input type="password" id="new-password" name="new_password" class="form-control" placeholder="{{ trans('crud/labels.new-password') }}"
                               required data-parsley-minlength="6" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" class="form-control" 
                               data-parsley-equalto="#new-password" required data-parsley-minlength="6" 
                               placeholder="{{ trans('crud/labels.password-confirmation') }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('crud/labels.update') }}</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('extra_js')
<script>
    function passUpdated(e){
        document.forms[0].reset();
        $('.ajax-errors').remove();
        $.bootstrapGrowl( _('Password updated'),{align:'center', type:'success'} );
    }
</script>
@stop