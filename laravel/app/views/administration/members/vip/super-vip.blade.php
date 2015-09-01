@extends('layouts.default')
@section('content')	
    


 <table class="table table-bordered table-striped">
     <thead>
         <tr>
            <td>RANK</td>
            <td>FIRST NAME}</td>
            <td>LAST NAME</td>
            <td>EMAIL</td>
            <td>REF. COUNT</td>
         </tr>
     </thead>
    <tbody>
        <?php $rank = 1;?>
        @foreach($vips as $vip)
            <tr>
                <td>{{ $rank }}</td>
                <td>{{$vip->first_name}}</td>
                <td>{{$vip->last_name}}</td>
                <td>{{ str_replace('#waa#-','', $vip->email) }}</td>
                <td>{{$vip->ref_count}}</td>
            </tr>
            <?php ++$rank;?>
        @endforeach
    </tbody>
 </table>

@stop