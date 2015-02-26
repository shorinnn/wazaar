@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="well margin-top-15">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                <div class="row">
                    <div class="col-md-7">
                        <h3>{{trans('profile.pageTitle')}}</h3>
                    </div>
                    <div class="col-md-5 margin-top-15">
                        <div class="dropdown pull-right">
                            <button class="btn btn-success" type="button" id="dropdownMenu1">
                                {{trans('profile.' . $type)}} {{trans('profile.profile')}}

                            </button>
                        </div>
                    </div>
                </div>

                <hr/>

                {{Form::open(['url' => 'profile/' . @$profile->id . '/update', 'class' => 'form-horizontal', 'files' => true])}}
                    <h4>{{trans('profile.headerPhoto')}}</h4>
                    <hr/>
                    <div class="text-center">
                        <div class="margin-bottom-15"><img src="{{@$profile->photo}}" alt=""/></div>
                        <div class="form-group">
                            {{Form::file('profilePicture')}}
                            <span class="label label-warning">{{trans('profile.allowedPictureFormat')}}</span>
                        </div>
                    </div>

                    <h4>{{trans('profile.headerPersonal')}}</h4>
                    <hr/>
                    @include('profile.partials.done.personal')

                    <h4>{{trans('profile.headerSocial')}}</h4>
                    <hr/>
                    @include('profile.partials.done.socialmedia')


                    {{Form::hidden('type', $type)}}
                    <div class="pull-right">{{Form::submit('Update',['class' => 'btn btn-success'])}}</div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
@stop