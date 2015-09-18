@extends('layouts.default')
@section('content')
    <div class="wrapper">
        <?php
        $i = 1;
        foreach($users as $user){
//            echo $user->fullName().','.$user->email.'<br />';.
            echo "$i, ";
            if( $user->profile!=null )
                echo $user->profile->last_name.' '.$user->profile->first_name.','.$user->email.'<br />';
            else
                echo $user->last_name.' '.$user->first_name.', '.$user->email.'<br />';
            ++$i;
        }
        ?>
    </div>

@stop
