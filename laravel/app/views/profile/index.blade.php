@extends('layouts.default')

@section('page_title')
    Profile - 
@stop

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

                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                {{trans('profile.' . $type)}} {{trans('profile.profile')}}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                @foreach($availableProfiles as $p)
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{url('profile/' . $p)}}">{{trans('profile.' . $p)}} {{trans('profile.profile')}}</a></li>
                                @endforeach

                            </ul>
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
                    
                    @if( $type != 'student')
                        <h4>{{trans('profile.headerFinancial')}}</h4>
                        <hr/>
                        @include('profile.partials.done.financial')
                    @endif

                    {{Form::hidden('type', $type)}}
                    <div class="pull-right">{{Form::submit('Update',['class' => 'btn btn-success'])}}</div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
@stop