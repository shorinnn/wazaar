@extends('layouts.default')
@section('content')	

<button class='btn btn-primary add-grid' onclick='addGrid()' data-cur-val='{{$videos->count()}}'>Add grid</button>
<button class='btn btn-primary remove-grid btn-danger' onclick='deleteGrid("first")'>Delete first grid (9 videos)</button>
{{ Form::open([ 'action' => ['FrontpageVideosController@update', 0], 'method' => 'PUT', 'class'=>'ajax-form',  'data-callback'=>'formSaved' ] ) }}
<center><button type='submit' class='btn btn-primary'>Update</button></center>
<table class="table table-striped table-bordered" style='width: 50%; margin-left:auto; margin-right: auto' id='grid-table'>
    <?php
    $i = 0;
    ?>
    @foreach($videos as $video)
        <?php $i++;?>
        {{ View::make('administration.frontpage_videos.partials.video')->with( compact( 'video', 'i', 'courses' ) )}}
    @endforeach
</table>
<center><button type='submit' class='btn btn-primary'>Update</button></center>
{{ Form::close() }}
<button class='btn btn-primary add-grid' onclick='addGrid()' data-cur-val='{{$videos->count()}}'>Add grid</button>
<button class='btn btn-primary remove-grid btn-danger' onclick='deleteGrid("last")'>Delete last grid (9 videos)</button>

@stop

@section('extra_js')
<script>
    function addGrid(){
        $('.add-grid').attr('data-old-label', $('.add-grid').html() );
        $('.add-grid').html( '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /> '+_('Please wait'));
        $.post(COCORIUM_APP_PATH+'administration/frontpage-videos', { i : $('.add-grid').attr('data-cur-val') },function(result){
            $('.add-grid').html( $('.add-grid').attr('data-old-label') );
            $('.add-grid').attr('data-cur-val', $('.add-grid').attr('data-cur-val') * 1 + 9 );
            $('#grid-table tbody').append(result);
            $('.select2').select2();
             $('html, body').animate({
                scrollTop: $('#grid-table tbody tr').last().offset().top
             }, 500);
        });
    }
    
    function deleteGrid(which){
        if(which=='first'){
            start_id = $('#grid-table tbody tr').first().attr('data-id');
            start = 1;
            end = start + 8;
        }
        else{
//            $('#grid-table tbody tr').last().attr('data-id');
            end = $('#grid-table tbody tr').last().attr('data-row-cur-val');
            start = end - 8;
            start_id = $('[data-row-cur-val="'+start+'"]').attr('data-id');
        }
        
        $('.remove-grid').prop('disabled', true);
        $('.remove-grid').attr('data-old-label', $('.remove-grid').html() );
        $('.remove-grid').html( '<img src="https://s3-ap-northeast-1.amazonaws.com/wazaar/assets/images/icons/ajax-loader.gif" /> '+_('Please wait'));
        $.post(COCORIUM_APP_PATH+'administration/frontpage-videos/0',{ _method:'DELETE', start: start_id}, function(){
            $('.remove-grid').html( $('.remove-grid').attr('data-old-label') );
            $('.remove-grid').prop('disabled', false);
            for(i = start; i < end + 1; ++i){
              $('[data-row-cur-val="'+i+'"]').remove();
            }
            i = 1;
            $('#grid-table tbody tr').each(function(){
                 $(this).find('td').first().html( i );
                 $(this).attr('data-row-cur-val', i);
                 ++i;
             });
            $('.add-grid').attr('data-cur-val', $('.add-grid').attr('data-cur-val') * 1 - 9 );
            
        });
    }
    $(function(){
         $('.select2').select2();
    });
</script>
@stop