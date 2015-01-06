@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="well margin-top-15">
                <h3>{{trans('profile.pageTitle')}}</h3>
                <hr/>

                {{Form::open(['url' => 'profile/' . $profile->id . '/update', 'class' => 'form-horizontal'])}}
                    <h4>{{trans('profile.headerPhoto')}}</h4>
                    <hr/>
                    <div class="text-center">
                        <img src="{{$profile->photo}}" alt=""/>
                    </div>

                    <h4>{{trans('profile.headerPersonal')}}</h4>
                    <hr/>
                    @include('profile.partials.done.personal')

                    <h4>{{trans('profile.headerSocial')}}</h4>
                    <hr/>
                    @include('profile.partials.done.socialmedia')



                    <div class="pull-right">{{Form::submit('Update',['class' => 'btn btn-success'])}}</div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
@stop