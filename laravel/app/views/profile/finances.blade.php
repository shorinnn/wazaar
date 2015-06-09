@extends('layouts.default')

@section('page_title')
    Finance - 
@stop

@section('content')
                <a class="btn btn-sm" href="?show=student">Student Balance</a> 

                @if(Auth::user()->hasRole('Instructor'))
                    <a class="btn btn-sm" href="?show=instructor">Instructor Balance</a> 
                @endif
                
                @if(Auth::user()->hasRole('Affiliate'))
                    <a class="btn btn-sm" href="?show=affiliate">Affiliate Balance</a> 
                @endif
                
                @if(Auth::user()->hasRole('InstructorAgency'))
                    <a class="btn btn-sm" href="?show=agency">Instructor Agency Balance</a> 
                @endif


    @if(Input::get('show')=='instructor' && get_class($user)=='Instructor' )
        {{ View::make('profile.partials.finances.non_student')->with( compact('user') )->withType('Instructor') }}
    @elseif(Input::get('show')=='affiliate' && get_class($user)=='LTCAffiliate' )
        {{ View::make('profile.partials.finances.non_student')->with( compact('user') )->withType('Affiliate') }}
    @elseif(Input::get('show')=='agency' && get_class($user)=='InstructorAgency' )
        {{ View::make('profile.partials.finances.non_student')->with( compact('user') )->withType('Instructor Agency') }}
    @else
        {{ View::make('profile.partials.finances.student')->with( compact('user') )->withType('Student') }}
    @endif
    
@stop