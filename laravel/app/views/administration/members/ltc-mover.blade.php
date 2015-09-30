@extends('layouts.default')
@section('content')	
    
<table class="table table-striped table-bordered">
    <tr>
        <td>2tier Pub</td>
        <td>Instructors Referred</td>
        <td>LTC Affiliate Account</td>
        <td>Current LTC Referrals</td>
        <td>LTC Referrals After Change</td>
    </tr>
    @foreach($stPubs as $pub)
    <tr>
        <td>#{{$pub->id}} {{$pub->email}}</td>
        <td>
            Total: {{ $pub->instructors->count() }}
            <div style="height: 100px; overflow-y:scroll">
                <table class="table table-striped table-condensed">
                    @foreach($pub->instructors as $i)
                    <tr><td>
                        #{{$i->id}} {{$i->email}}
                        [ 
                            Current LTC: 
                            @if( $i->ltcAffiliate==null )
                                N/A {{$i->ltc_affiliate_id}}
                            @else
                                <span class="label label-success">#{{ $i->ltcAffiliate->id }}
                                {{ $i->ltcAffiliate->email }}</span>
                            @endif
                        ]
                    </td></tr>
                    @endforeach
                </table>
            </div>
        </td>
        <td>
            <?php
               $ltc = LTCAffiliate::where('email', '#waa#-'.$pub->email)->first();
            ?>
            @if($ltc != null)
                #{{$ltc->id}} {{$ltc->email}}
            @else
                N/A
            @endif
        </td>
        <td>
            @if($ltc != null)
                Total: {{ $ltc->affiliated->count() }}
                <div style="height: 100px; overflow-y:scroll">
                    <table class="table table-striped table-condensed">
                    @foreach($ltc->affiliated as $i)
                        <tr><td>
                            #{{$i->id}} {{$i->email}}
                        </td></tr>
                    @endforeach
                    </table>
                </div>
            @else
                N/A
            @endif
        </td>
        <td>
            @if($ltc != null)
            <?php
                $affiliatedArr = [];
                
                foreach($pub->instructors as $affd){
                    $affiliatedArr[$affd->id] = $affd->email;
                }
                
                foreach($ltc->affiliated as $affd){
                    $affiliatedArr[$affd->id] = $affd->email;
                }
//                asort($affiliatedArr);
            ?>
                Total: {{ count($affiliatedArr) }}
                <div style="height: 100px; overflow-y:scroll">
                    <table class="table table-striped table-condensed">
                        @foreach($affiliatedArr as $i=>$email)
                            <tr><td>
                                #{{$i}} {{$email}}
                            </td></tr>
                        @endforeach
                    </table>
                </div>
            @else
                N/A
            @endif
        </td>
    </tr>
    
    @endforeach
</table>
{{ $stPubs->links() }}
{{ Form::open(['action' => 'MembersController@doLtcMove']) }}
<center>
     @foreach($stPubs as $pub)
         <input type="hidden" name="ids[]" value="{{$pub->id}}" />
     @endforeach
     <input type="hidden" name="url" value="{{ Request::url() }}?page={{Input::get('page')}}" />
    <input class='btn btn-primary' type='submit' value='Change LTC' onclick='return confirm("Are you sure?")' />
</center>
{{ Form::close() }}
@stop